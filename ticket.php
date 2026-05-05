<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");

Sicherheit::requireLogin();

$link       = DbFunctions::connectWithDatabase();
$benutzerID = $_SESSION['benutzerID'];

// Bestellungs-IDs aus URL
$idsRaw = $_GET['ids'] ?? '';
$ids    = array_filter(array_map('intval', explode(',', $idsRaw)));

if (empty($ids)) {
    header('Location: meine_bestellungen.php');
    exit();
}

// Bestellungen laden und auf Eigentümer prüfen
$tickets = [];
foreach ($ids as $bestellID) {
    $bestellung = TicketEntity::holeBestellungPerID($link, $bestellID, $benutzerID);
    if ($bestellung) {
        // QR-Code Inhalt: eindeutige Ticket-ID
        $qrInhalt = 'S04-TICKET-' . $bestellID . '-' . $benutzerID . '-' . $bestellung['spiel_id'];
        $bestellung['qr_inhalt']   = $qrInhalt;
        $bestellung['bestellungID'] = $bestellID;
        $tickets[] = $bestellung;
    }
}

if (empty($tickets)) {
    header('Location: meine_bestellungen.php');
    exit();
}

// ── PDF-Download ─────────────────────────────────────────────────────
if (isset($_GET['pdf'])) {
    require_once("vendor/autoload.php"); // TCPDF via Composer

    $pdf = new TCPDF('L', 'mm', [210, 100], true, 'UTF-8');
    $pdf->SetCreator('FC Schalke 04 Ticketsystem');
    $pdf->SetAuthor('FC Schalke 04');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(false);

    foreach ($tickets as $ticket) {
        $pdf->AddPage();

        // Hintergrund blau links
        $pdf->SetFillColor(0, 75, 157);
        $pdf->Rect(0, 0, 70, 100, 'F');

        // Weißer Text links
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetXY(5, 8);
        $pdf->Cell(60, 8, 'FC SCHALKE 04', 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(5, 18);
        $pdf->Cell(60, 5, 'EINTRITTSKARTE', 0, 1, 'C');

        // Trennlinie
        $pdf->SetDrawColor(255, 255, 255);
        $pdf->Line(5, 25, 65, 25);

        // Spiel
        $gegner = $ticket['gegner'];
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->SetXY(5, 28);
        $pdf->MultiCell(60, 6, "FC Schalke 04\nvs. $gegner", 0, 'C');

        // Datum
        $datum = date('d.m.Y', strtotime($ticket['datum']));
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(5, 44);
        $pdf->Cell(60, 5, $datum, 0, 1, 'C');

        // Stadion
        $pdf->SetXY(5, 50);
        $pdf->Cell(60, 5, 'Veltins-Arena', 0, 1, 'C');

        // Trennlinie
        $pdf->Line(5, 57, 65, 57);

        // Platzinfos
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetXY(5, 60);
        $pdf->Cell(60, 5, 'Block ' . $ticket['block'], 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(5, 66);
        $pdf->Cell(60, 5, 'Reihe ' . $ticket['reihe'] . '  |  Platz ' . $ticket['platz'], 0, 1, 'C');
        $pdf->SetXY(5, 72);
        $pdf->Cell(60, 5, $ticket['kategorie'], 0, 1, 'C');

        // Preis
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->SetXY(5, 80);
        $preis = number_format($ticket['preis_bezahlt'] ?? $ticket['preis'] ?? 0, 2, ',', '.');
        $pdf->Cell(60, 8, $preis . ' EUR', 0, 1, 'C');

        // Rechter Bereich: weiß
        $pdf->SetTextColor(0, 0, 0);

        // Ticket-Nr
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetXY(72, 8);
        $pdf->Cell(80, 5, 'Ticket-Nr: S04-' . str_pad($ticket['bestellungID'], 6, '0', STR_PAD_LEFT), 0, 1, 'L');

        // QR-Code generieren (Base64 PNG via Google Charts API als Fallback)
        // Besser: chillerlan/php-qrcode falls installiert
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=' . urlencode($ticket['qr_inhalt']);
        $pdf->Image($qrUrl, 155, 10, 45, 45, 'PNG');

        // Vertikale Trennlinie
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(70, 5, 70, 95);

        // Gestrichelte Abreißkante
        $pdf->SetLineStyle(['dash' => '3,3']);
        $pdf->Line(148, 5, 148, 95);
        $pdf->SetLineStyle(['dash' => 0]);

        // Info Text
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetTextColor(0, 75, 157);
        $pdf->SetXY(72, 16);
        $pdf->Cell(74, 6, 'FC Schalke 04 vs. ' . $gegner, 0, 1, 'L');

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(72, 23);
        $pdf->Cell(74, 5, 'Datum: ' . $datum, 0, 1, 'L');
        $pdf->SetXY(72, 29);
        $pdf->Cell(74, 5, 'Stadion: Veltins-Arena', 0, 1, 'L');
        $pdf->SetXY(72, 35);
        $pdf->Cell(74, 5, 'Block: ' . $ticket['block'] . '  |  Reihe: ' . $ticket['reihe'] . '  |  Platz: ' . $ticket['platz'], 0, 1, 'L');
        $pdf->SetXY(72, 41);
        $pdf->Cell(74, 5, 'Kategorie: ' . $ticket['kategorie'], 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->SetXY(72, 50);
        $pdf->Cell(74, 6, 'Preis: ' . $preis . ' EUR', 0, 1, 'L');

        // Hinweistext
        $pdf->SetFont('helvetica', 'I', 7);
        $pdf->SetTextColor(120, 120, 120);
        $pdf->SetXY(72, 80);
        $pdf->MultiCell(74, 4, 'Dieses Ticket ist personengebunden und nicht übertragbar. Bitte QR-Code beim Einlass vorzeigen.', 0, 'L');

        // QR Code Label
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetXY(152, 56);
        $pdf->Cell(50, 4, 'Scan beim Einlass', 0, 1, 'C');
    }

    $pdf->Output('Schalke04_Tickets.pdf', 'D');
    exit();
}

// ── HTML Ansicht ─────────────────────────────────────────────────────
$smarty->assign('tickets',    $tickets);
$smarty->assign('ids',        implode(',', $ids));
$smarty->assign('seitentitel', 'Deine Tickets');
$smarty->display('ticket.tpl');
?>
