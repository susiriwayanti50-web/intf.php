<?php

interface MetodePembayaran
{
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

class TransferBank implements MetodePembayaran
{
    private string $noRekening;

    public function __construct(string $noRekening)
    {
        $this->noRekening = $noRekening;
    }

    private function formatRupiah(float $angka): string
    {
        return "Rp " . number_format($angka, 0, ',', '.');
    }

    public function getNamaMetode(): string
    {
        return "Transfer Bank";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool
    {
        $biayaAdmin = 0; // 0%
        $total = $jumlah + $biayaAdmin;

        echo "--- " . $this->getNamaMetode() . " ---\n";
        echo "No. Rekening : " . $this->noRekening . "\n";
        echo "Keterangan   : " . $keterangan . "\n";
        echo "Jumlah       : " . $this->formatRupiah($jumlah) . "\n";
        echo "Biaya Admin  : 0% (" . $this->formatRupiah($biayaAdmin) . ")\n";
        echo "Total Bayar  : " . $this->formatRupiah($total) . "\n";
        echo "Status       : BERHASIL\n\n";

        return true;
    }
}

class QRIS implements MetodePembayaran
{
    private function formatRupiah(float $angka): string
    {
        return "Rp " . number_format($angka, 0, ',', '.');
    }

    public function getNamaMetode(): string
    {
        return "QRIS";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool
    {
        $biayaAdmin = $jumlah * 0.007; // 0.7%
        $total = $jumlah + $biayaAdmin;

        echo "--- " . $this->getNamaMetode() . " ---\n";
        echo "Keterangan   : " . $keterangan . "\n";
        echo "Jumlah       : " . $this->formatRupiah($jumlah) . "\n";
        echo "Biaya Admin  : 0.7% (" . $this->formatRupiah($biayaAdmin) . ")\n";
        echo "Total Bayar  : " . $this->formatRupiah($total) . "\n";
        echo "Status       : BERHASIL\n\n";

        return true;
    }
}

class KartuKredit implements MetodePembayaran
{
    private string $noKartu;

    public function __construct(string $noKartu)
    {
        $this->noKartu = $noKartu;
    }

    private function formatRupiah(float $angka): string
    {
        return "Rp " . number_format($angka, 0, ',', '.');
    }

    public function getNamaMetode(): string
    {
        return "Kartu Kredit";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool
    {
        $biayaAdmin = $jumlah * 0.025; // 2.5%
        $total = $jumlah + $biayaAdmin;
        $kartuTampil = "**** **** **** " . substr($this->noKartu, -4);

        echo "--- " . $this->getNamaMetode() . " ---\n";
        echo "No. Kartu    : " . $kartuTampil . "\n";
        echo "Keterangan   : " . $keterangan . "\n";
        echo "Jumlah       : " . $this->formatRupiah($jumlah) . "\n";
        echo "Biaya Admin  : 2.5% (" . $this->formatRupiah($biayaAdmin) . ")\n";
        echo "Total Bayar  : " . $this->formatRupiah($total) . "\n";
        echo "Status       : BERHASIL\n\n";

        return true;
    }
}

// FUNGSI POLYMORPHISM
function bayarPesanan(MetodePembayaran $metode, float $jumlah, string $keterangan)
{
    $metode->prosesBayar($jumlah, $keterangan);
}

// CONTOH PENGGUNAAN
bayarPesanan(new TransferBank("1234567890"), 500000, "Beli Laptop");
bayarPesanan(new QRIS(), 500000, "Beli Kopi");
bayarPesanan(new KartuKredit("1234567812345678"), 500000, "Beli HP");