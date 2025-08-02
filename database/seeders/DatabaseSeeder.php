<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpustakaan.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create Regular User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@perpustakaan.com',
            'role' => 'user',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create Member for User
        Member::create([
            'member_number' => 'MEM' . date('Y') . '0001',
            'name' => 'John Doe',
            'email' => 'user@perpustakaan.com',
            'phone' => '081234567890',
            'address' => 'Jl. Contoh No. 123, Jakarta',
            'join_date' => now(),
            'status' => 'active',
        ]);

        // Create Sample Books
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '9786020331775',
                'category' => 'Fiksi',
                'description' => 'Novel yang mengisahkan tentang perjuangan anak-anak di Belitung untuk mendapatkan pendidikan.',
                'stock' => 5,
                'available' => 5,
                'publication_year' => 2005,
                'publisher' => 'Bentang Pustaka',
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'isbn' => '9786020318837',
                'category' => 'Sejarah',
                'description' => 'Novel tetralogi Buru yang mengisahkan kehidupan di masa kolonial Belanda.',
                'stock' => 3,
                'available' => 3,
                'publication_year' => 1980,
                'publisher' => 'Hasta Mitra',
            ],
            [
                'title' => 'Negeri 5 Menara',
                'author' => 'Ahmad Fuadi',
                'isbn' => '9786028811507',
                'category' => 'Biografi',
                'description' => 'Kisah inspiratif tentang perjuangan menuntut ilmu di pesantren.',
                'stock' => 4,
                'available' => 4,
                'publication_year' => 2009,
                'publisher' => 'Gramedia Pustaka Utama',
            ],
            [
                'title' => 'Ayat-Ayat Cinta',
                'author' => 'Habiburrahman El Shirazy',
                'isbn' => '9786020310527',
                'category' => 'Religi',
                'description' => 'Novel yang mengisahkan perjalanan seorang mahasiswa Indonesia di Mesir.',
                'stock' => 2,
                'available' => 2,
                'publication_year' => 2004,
                'publisher' => 'Republika',
            ],
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'isbn' => '9786026699312',
                'category' => 'Filosofi',
                'description' => 'Panduan praktis menerapkan filosofi Stoikisme dalam kehidupan sehari-hari.',
                'stock' => 6,
                'available' => 6,
                'publication_year' => 2018,
                'publisher' => 'Kompas Gramedia',
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'isbn' => '9780062316097',
                'category' => 'Sejarah',
                'description' => 'Sejarah singkat umat manusia dari zaman batu hingga era modern.',
                'stock' => 3,
                'available' => 3,
                'publication_year' => 2014,
                'publisher' => 'Harper',
            ],
            [
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho',
                'isbn' => '9780062315007',
                'category' => 'Fiksi',
                'description' => 'Kisah perjalanan seorang gembala untuk menemukan harta karun dan jati dirinya.',
                'stock' => 4,
                'available' => 4,
                'publication_year' => 1988,
                'publisher' => 'HarperOne',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'category' => 'Teknologi',
                'description' => 'Panduan menulis kode yang bersih dan mudah dipelihara.',
                'stock' => 2,
                'available' => 2,
                'publication_year' => 2008,
                'publisher' => 'Prentice Hall',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Create more members
        $members = [
            [
                'member_number' => 'MEM' . date('Y') . '0002',
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '081234567891',
                'address' => 'Jl. Merdeka No. 45, Jakarta',
                'join_date' => now()->subDays(30),
                'status' => 'active',
            ],
            [
                'member_number' => 'MEM' . date('Y') . '0003',
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'phone' => '081234567892',
                'address' => 'Jl. Sudirman No. 78, Jakarta',
                'join_date' => now()->subDays(60),
                'status' => 'active',
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}