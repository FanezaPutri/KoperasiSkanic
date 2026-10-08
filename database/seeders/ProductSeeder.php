<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');

        $productsData = [
            // 1. Makanan & Minuman
            'makanan-minuman' => [
                [
                    'name' => 'Roti Aoka Aneka Rasa',
                    'description' => 'Roti panggang lembut dengan aneka varian rasa coklat, keju, dan vanila.',
                    'price' => 3000,
                    'cost_price' => 2200,
                    'stock' => 25,
                ],
                [
                    'name' => 'Teh Botol Sosro 250ml',
                    'description' => 'Minuman teh melati segar dingin khas koperasi sekolah.',
                    'price' => 4000,
                    'cost_price' => 3100,
                    'stock' => 30,
                ],
                [
                    'name' => 'Air Mineral Club 600ml',
                    'description' => 'Air minum mineral murni higienis untuk menjaga hidrasi saat belajar.',
                    'price' => 3000,
                    'cost_price' => 2000,
                    'stock' => 48,
                ],
                [
                    'name' => 'Mie Sedaap Cup Goreng',
                    'description' => 'Mie instan cup praktis siap seduh dengan taburan kriuk gurih.',
                    'price' => 6000,
                    'cost_price' => 4800,
                    'stock' => 20,
                ],
                [
                    'name' => 'Beng-Beng Wafer Coklat',
                    'description' => 'Wafer coklat renyah berlapis karamel dan beras renyah gurih.',
                    'price' => 2500,
                    'cost_price' => 1900,
                    'stock' => 35,
                ],
                [
                    'name' => 'Susu Ultra Milk UHT 200ml',
                    'description' => 'Susu segar berenergi pilihan rasa coklat dan strawberry.',
                    'price' => 6500,
                    'cost_price' => 5200,
                    'stock' => 24,
                ],
            ],

            // 2. Alat Tulis
            'alat-tulis' => [
                [
                    'name' => 'Pulpen Faster C600 Hitam',
                    'description' => 'Pulpen gel tinta hitam pekat anti macet untuk catatan dan tugas harian.',
                    'price' => 3500,
                    'cost_price' => 2600,
                    'stock' => 50,
                ],
                [
                    'name' => 'Pensil 2B Faber-Castell',
                    'description' => 'Pensil grafit standar ujian nasional dengan tingkat kehitaman presisi.',
                    'price' => 4000,
                    'cost_price' => 3000,
                    'stock' => 40,
                ],
                [
                    'name' => 'Buku Tulis Sinar Dunia 38 Lembar',
                    'description' => 'Buku tulis bergaris tebal dengan kertas putih bersih kualitas terbaik.',
                    'price' => 5000,
                    'cost_price' => 3800,
                    'stock' => 60,
                ],
                [
                    'name' => 'Penghapus Joyko Hitam',
                    'description' => 'Penghapus bebas debu yang membersihkan bekas pensil tanpa merusak kertas.',
                    'price' => 2000,
                    'cost_price' => 1200,
                    'stock' => 30,
                ],
                [
                    'name' => 'Tipe-X Kertas Joyko Tape',
                    'description' => 'Pita koreksi praktis cepat kering yang bisa langsung ditimpa tulisan pena.',
                    'price' => 7000,
                    'cost_price' => 5400,
                    'stock' => 25,
                ],
                [
                    'name' => 'Penggaris Plastik 30cm',
                    'description' => 'Penggaris lurus transparan dengan skala angka yang jelas dan presisi.',
                    'price' => 3000,
                    'cost_price' => 1800,
                    'stock' => 25,
                ],
            ],

            // 3. Atribut Sekolah
            'atribut-sekolah' => [
                [
                    'name' => 'Dasi Seragam Skanic',
                    'description' => 'Dasi resmi seragam sekolah dengan bordir logo resmi institusi.',
                    'price' => 15000,
                    'cost_price' => 11000,
                    'stock' => 30,
                ],
                [
                    'name' => 'Topi Upacara Sekolah',
                    'description' => 'Topi upacara resmi bahan drill halus adem dilengkapi logo bordir.',
                    'price' => 20000,
                    'cost_price' => 15000,
                    'stock' => 25,
                ],
                [
                    'name' => 'Sabuk Ikat Pinggang Sekolah',
                    'description' => 'Ikat pinggang standar sekolah dengan kepala gesper plat logo sekolah.',
                    'price' => 18000,
                    'cost_price' => 13500,
                    'stock' => 25,
                ],
                [
                    'name' => 'Kaos Kaki Putih Telapak Hitam',
                    'description' => 'Kaos kaki sekolah tebal elastis menyerap keringat dan tidak mudah melar.',
                    'price' => 10000,
                    'cost_price' => 7500,
                    'stock' => 35,
                ],
                [
                    'name' => 'Badge Emblem & Bet OSIS Bordir',
                    'description' => 'Set bet lokasi sekolah dan emblem logo OSIS siap jahit.',
                    'price' => 5000,
                    'cost_price' => 3000,
                    'stock' => 50,
                ],
            ],

            // 4. Kebersihan
            'kebersihan' => [
                [
                    'name' => 'Tissue Kering Saku Paseo',
                    'description' => 'Tisu saku higienis dan lembut untuk kebutuhan personal harian.',
                    'price' => 4500,
                    'cost_price' => 3200,
                    'stock' => 30,
                ],
                [
                    'name' => 'Tissue Basah Antiseptik Mitu',
                    'description' => 'Tisu basah wangi pembasmi bakteri untuk membersihkan meja dan tangan.',
                    'price' => 5000,
                    'cost_price' => 3800,
                    'stock' => 20,
                ],
                [
                    'name' => 'Hand Sanitizer Dettol 50ml',
                    'description' => 'Gel pembersih tangan antibakteri cepat kering tanpa rasa lengket.',
                    'price' => 10000,
                    'cost_price' => 7500,
                    'stock' => 15,
                ],
                [
                    'name' => 'Sabun Cuci Tangan Lifebuoy',
                    'description' => 'Sabun cair antibakteri menjaga kebersihan tangan kelas & toilet.',
                    'price' => 12000,
                    'cost_price' => 9500,
                    'stock' => 12,
                ],
            ],

            // 5. Obat
            'obat' => [
                [
                    'name' => 'Minyak Kayu Putih Cap Lang 30ml',
                    'description' => 'Minyak aromaterapi alami meredakan perut kembung, pusing, dan mual.',
                    'price' => 13000,
                    'cost_price' => 10500,
                    'stock' => 15,
                ],
                [
                    'name' => 'Plester Luka Hansaplast Strip',
                    'description' => 'Plester elastis kedap air untuk pertolongan pertama pada luka kecil.',
                    'price' => 1500,
                    'cost_price' => 800,
                    'stock' => 60,
                ],
                [
                    'name' => 'Tolak Angin Sido Muncul Cair',
                    'description' => 'Herbal cair pereda masuk angin, mual, pegal-pegal, dan meriang.',
                    'price' => 4000,
                    'cost_price' => 3000,
                    'stock' => 40,
                ],
                [
                    'name' => 'Bodrex Sakit Kepala Strip',
                    'description' => 'Tablet pereda sakit kepala, demam, dan nyeri secara cepat dan efektif.',
                    'price' => 4500,
                    'cost_price' => 3200,
                    'stock' => 20,
                ],
                [
                    'name' => 'Promag Obat Maag Kunyah',
                    'description' => 'Tablet kunyah pereda nyeri lambung, maag, dan perut begah.',
                    'price' => 8000,
                    'cost_price' => 6200,
                    'stock' => 20,
                ],
            ],

            // 6. Jasa E-Wallet (E-Money)
            'jasa-e-wallet' => [
                [
                    'name' => 'Top Up DANA Rp 10.000',
                    'description' => 'Pengisian saldo DANA nominal Rp 10.000. Masukkan nomor DANA di kolom catatan.',
                    'price' => 12000,
                    'cost_price' => 10500,
                    'stock' => 0,
                ],
                [
                    'name' => 'Top Up DANA Rp 20.000',
                    'description' => 'Pengisian saldo DANA nominal Rp 20.000. Tuliskan nomor akun tujuan pada catatan.',
                    'price' => 22000,
                    'cost_price' => 20500,
                    'stock' => 0,
                ],
                [
                    'name' => 'Top Up GoPay Rp 10.000',
                    'description' => 'Isi saldo GoPay Rp 10.000 instan. Cantumkan nomor HP terdaftar pada catatan.',
                    'price' => 12000,
                    'cost_price' => 10500,
                    'stock' => 0,
                ],
                [
                    'name' => 'Top Up GoPay Rp 20.000',
                    'description' => 'Isi saldo GoPay Rp 20.000 praktis. Cantumkan nomor akun GoPay pada catatan.',
                    'price' => 22000,
                    'cost_price' => 20500,
                    'stock' => 0,
                ],
                [
                    'name' => 'Top Up ShopeePay Rp 20.000',
                    'description' => 'Isi saldo ShopeePay nominal Rp 20.000. Cantumkan nomor terdaftar pada catatan.',
                    'price' => 22000,
                    'cost_price' => 20500,
                    'stock' => 0,
                ],
                [
                    'name' => 'Top Up OVO Rp 20.000',
                    'description' => 'Top up saldo OVO Cash nominal Rp 20.000. Masukkan nomor OVO pada catatan.',
                    'price' => 22500,
                    'cost_price' => 20500,
                    'stock' => 0,
                ],
            ],

            // 7. Pulsa Seluler
            'pulsa' => [
                [
                    'name' => 'Pulsa Telkomsel Rp 5.000',
                    'description' => 'Pengisian pulsa reguler Telkomsel / By.U Rp 5.000. Tulis nomor HP di kolom catatan.',
                    'price' => 7000,
                    'cost_price' => 5800,
                    'stock' => 0,
                ],
                [
                    'name' => 'Pulsa Telkomsel Rp 10.000',
                    'description' => 'Pengisian pulsa Telkomsel Rp 10.000 langsung aktif. Cantumkan nomor HP di catatan.',
                    'price' => 12000,
                    'cost_price' => 10500,
                    'stock' => 0,
                ],
                [
                    'name' => 'Pulsa Indosat IM3 Rp 10.000',
                    'description' => 'Pulsa reguler Indosat IM3 Rp 10.000. Tuliskan nomor HP tujuan di catatan.',
                    'price' => 12000,
                    'cost_price' => 10400,
                    'stock' => 0,
                ],
                [
                    'name' => 'Pulsa XL / AXIS Rp 10.000',
                    'description' => 'Pengisian pulsa nomor XL atau AXIS Rp 10.000. Cantumkan nomor HP di catatan.',
                    'price' => 12000,
                    'cost_price' => 10300,
                    'stock' => 0,
                ],
                [
                    'name' => 'Pulsa Smartfren Rp 10.000',
                    'description' => 'Pengisian pulsa Smartfren Rp 10.000 cepat & praktis. Tuliskan nomor HP di catatan.',
                    'price' => 11500,
                    'cost_price' => 10100,
                    'stock' => 0,
                ],
            ],

            // 8. Photocopy & Print
            'photocopy' => [
                [
                    'name' => 'Fotokopi Hitam Putih (Per Lembar)',
                    'description' => 'Fotokopi 1 sisi kertas HVS 70-80gr jernih dan tajam.',
                    'price' => 500,
                    'cost_price' => 250,
                    'stock' => 0,
                ],
                [
                    'name' => 'Fotokopi Bolak-Balik (Per Lembar)',
                    'description' => 'Fotokopi 2 sisi bolak-balik hemat kertas untuk materi banyak halaman.',
                    'price' => 800,
                    'cost_price' => 400,
                    'stock' => 0,
                ],
                [
                    'name' => 'Print Dokumen Teks Hitam Putih',
                    'description' => 'Cetak dokumen tugas / makalah teks hitam via printer laser berkecepatan tinggi.',
                    'price' => 1000,
                    'cost_price' => 400,
                    'stock' => 0,
                ],
                [
                    'name' => 'Print Dokumen Warna / Bergambar',
                    'description' => 'Cetak dokumen halaman bergambar atau cover makalah berwarna cerah.',
                    'price' => 2500,
                    'cost_price' => 1000,
                    'stock' => 0,
                ],
                [
                    'name' => 'Jilid Makalah Mika Lakban',
                    'description' => 'Penjilidan dokumen sekolah dengan cover mika bening depan & lakban hitam rapi.',
                    'price' => 5000,
                    'cost_price' => 2500,
                    'stock' => 0,
                ],
            ],
        ];

        foreach ($productsData as $slug => $items) {
            $category = $categories->get($slug);
            if (! $category) {
                continue;
            }

            foreach ($items as $item) {
                Product::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'name' => $item['name'],
                    ],
                    [
                        'description' => $item['description'],
                        'price' => $item['price'],
                        'cost_price' => $item['cost_price'],
                        'stock' => $item['stock'],
                    ]
                );
            }
        }
    }
}
