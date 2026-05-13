<?php
class ProfilbildHelper {

    const UPLOAD_DIR     = 'uploads/profilbilder/';
    const MAX_GROESSE    = 2097152; // 2 MB
    const ERLAUBTE_TYPEN = ['image/jpeg', 'image/png', 'image/webp'];
    const ERLAUBTE_ENDUNGEN = ['jpg', 'jpeg', 'png', 'webp'];

    /**
     * Lädt ein Profilbild hoch und gibt den Dateinamen zurück.
     * Bei Fehler wird ein String mit der Fehlermeldung zurückgegeben.
     *
     * @return string|null  Dateiname bei Erfolg, null wenn keine Datei, false bei Fehler
     */
    public static function verarbeiteUpload(array $file, int $benutzerID): string|null|false {

        // Keine Datei gewählt
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        // Upload-Fehler
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Größe prüfen
        if ($file['size'] > self::MAX_GROESSE) {
            return false;
        }

        // MIME-Typ prüfen (sicher via finfo)
        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $mimeTyp  = $finfo->file($file['tmp_name']);
        if (!in_array($mimeTyp, self::ERLAUBTE_TYPEN, true)) {
            return false;
        }

        // Endung bestimmen
        $endungMap = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];
        $endung = $endungMap[$mimeTyp];

        // Altes Profilbild löschen falls vorhanden
        self::loescheAltesBild($benutzerID);

        // Eindeutigen Dateinamen generieren
        $dateiname = 'profil_' . $benutzerID . '_' . bin2hex(random_bytes(6)) . '.' . $endung;
        $zielPfad  = self::UPLOAD_DIR . $dateiname;

        if (!move_uploaded_file($file['tmp_name'], $zielPfad)) {
            return false;
        }

        return $dateiname;
    }

    /**
     * Löscht das bisherige Profilbild eines Nutzers vom Dateisystem.
     */
    public static function loescheAltesBild(int $benutzerID): void {
        // Alle Dateien mit profil_{benutzerID}_ suchen und löschen
        $muster = self::UPLOAD_DIR . 'profil_' . $benutzerID . '_*';
        foreach (glob($muster) as $datei) {
            if (is_file($datei)) {
                unlink($datei);
            }
        }
    }

    /**
     * Gibt den öffentlichen Pfad zum Profilbild zurück,
     * oder null wenn keins gesetzt ist.
     */
    public static function holePfad(?string $dateiname): ?string {
        if (!$dateiname) return null;
        $pfad = self::UPLOAD_DIR . $dateiname;
        return file_exists($pfad) ? $pfad : null;
    }
}
?>
