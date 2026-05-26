<?php

class Sicherheit {

    // --------------------------------------------------------
    // Aus dem Originalprojekt übernommen & erweitert
    // --------------------------------------------------------

    static function groesserAls($zahl, $min): bool {
        return $zahl > $min;
    }

    static function kleinerAls($zahl, $max): bool {
        return $zahl < $max;
    }

    static function zwischen($zahl, $min, $max): bool {
        return $zahl >= $min && $zahl <= $max;
    }

    static function istZahl($wert): bool {
        return is_numeric($wert);
    }

    static function istGanzeZahl($wert): bool {
        return is_numeric($wert) && (int) $wert == $wert && (int) $wert > 0;
    }

    static function pflichtfeld($wert): bool {
        return isset($wert) && trim($wert) !== '';
    }

    static function istString($wert): bool {
        return is_string($wert);
    }

    // --------------------------------------------------------
    // Neu: Ticketsystem-spezifische Validierungen
    // --------------------------------------------------------

    static function validiereEmail($email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false
            && strlen($email) <= 150;
    }

    static function validierePasswort($passwort): bool {
        // Mindestens 8 Zeichen, 1 Großbuchstabe, 1 Zahl
        return strlen($passwort) >= 8
            && preg_match('/[A-Z]/', $passwort)
            && preg_match('/[0-9]/', $passwort);
    }

    static function pruefePasswort($passwortKlartext, $hashAusDatenbank): bool {
        return password_verify($passwortKlartext, $hashAusDatenbank);
    }

    static function validiereDatum($datum): bool {
        // Erwartet Format YYYY-MM-DD
        $d = DateTime::createFromFormat('Y-m-d', $datum);
        return $d && $d->format('Y-m-d') === $datum;
    }

    static function validiereZahlungsart($wert): bool {
        $erlaubt = ['kreditkarte', 'paypal', 'sofortuberweisung', 'bar'];
        return in_array($wert, $erlaubt, true);
    }

    static function validiereAnzahl($anzahl, int $max = 10): bool {
        return self::istGanzeZahl($anzahl)
            && (int) $anzahl >= 1
            && (int) $anzahl <= $max;
    }

    static function bereinigeName($wert): string {
        return htmlspecialchars(strip_tags(trim($wert)), ENT_QUOTES, 'UTF-8');
    }

    // --------------------------------------------------------
    // Session & CSRF
    // --------------------------------------------------------

    static function csrfTokenErstellen(): string {
        if (!isset($_SESSION['csrfToken'])) {
            $_SESSION['csrfToken'] = bin2hex(random_bytes(64));
        }
        return $_SESSION['csrfToken'];
    }

    static function csrfTokenPruefen($tokenAusFormular): bool {
        if (!isset($_SESSION['csrfToken']) || !isset($tokenAusFormular)) {
            return false;
        }
        $gueltig = hash_equals($_SESSION['csrfToken'], $tokenAusFormular);
        // Token nach Prüfung erneuern (One-Time-Use)
        unset($_SESSION['csrfToken']);
        return $gueltig;
    }

    // --------------------------------------------------------
    // Rechteverwaltung
    // --------------------------------------------------------

    static function istEingeloggt(): bool {
        return isset($_SESSION['benutzerID']) && isset($_SESSION['rolle']);
    }

    static function istAdmin(): bool {
        return self::istEingeloggt() && $_SESSION['rolle'] === 'admin';
    }

    static function requireLogin(): void {
        if (!self::istEingeloggt()) {
            header('Location: login.php');
            exit();
        }
    }

    static function requireAdmin(): void {
        if (!self::istAdmin()) {
            header('Location: admin.php');
            exit();
        }
    }
}
?>
