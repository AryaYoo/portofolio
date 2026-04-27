<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin User ────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@portfolio.com'],
            [
                'name' => 'Yohanes',
                'password' => Hash::make('password'),
            ]
        );

        // ─── Profile ──────────────────────────────────────
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Yohanes Mahardika Arya Putra Cahyana',
                'short_name' => 'Yohanes',
                'title' => 'UI/UX Designer',
                'bio' => "Yohanes Mahardika Arya Putra Cahyana is a tech-savvy UI/UX Designer who believes that great design is the result of empathy executed with clear purpose.\n\nWith an educational background in Information Systems and a proven track record across various roles, he consistently demonstrates his drive and ambition within the IT and design industries.",
                'quote' => 'great design is the result of empathy executed with clear purpose',
                'email' => 'yohanes@example.com',
                'phone' => '+62 812 3456 7890',
                'location' => 'Indonesia',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/yohanes',
                    'github' => 'https://github.com/yohanes',
                    'dribbble' => 'https://dribbble.com/yohanes',
                    'instagram' => 'https://instagram.com/yohanes',
                ],
            ]
        );

        // ─── Best Projects ────────────────────────────────
        Project::updateOrCreate(
            ['title' => 'Laralite'],
            [
                'subtitle' => 'SIMRS Migration: A User-Centric Approach',
                'description' => 'A comprehensive hospital management system migration project focusing on user-centric design principles. The project involved redesigning the entire SIMRS interface to improve usability and efficiency for healthcare professionals.',
                'category' => 'best',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Project::updateOrCreate(
            ['title' => 'TarikSIS'],
            [
                'subtitle' => 'A simple approach to streamlining pharmacy data reporting.',
                'description' => 'A streamlined pharmacy data reporting system designed to simplify complex data workflows. Built with a focus on ease of use and accurate data visualization for pharmacy management.',
                'category' => 'best',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        Project::updateOrCreate(
            ['title' => 'SuperJob'],
            [
                'subtitle' => 'Job portal optimization for better user experience.',
                'description' => 'A job portal optimization project aimed at improving the overall user experience for both job seekers and employers. Focused on intuitive navigation and efficient job matching algorithms.',
                'category' => 'best',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        // ─── Other Projects ───────────────────────────────
        Project::updateOrCreate(
            ['title' => 'TarikSIS', 'category' => 'other'],
            [
                'subtitle' => 'Pharmacy data reporting tool',
                'description' => 'Streamlined pharmacy data reporting system.',
                'category' => 'other',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Project::updateOrCreate(
            ['title' => 'MasTolongMas'],
            [
                'subtitle' => 'Community helper platform',
                'description' => 'A community-driven platform connecting people who need help with volunteers.',
                'category' => 'other',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        Project::updateOrCreate(
            ['title' => 'Trash Scanner'],
            [
                'subtitle' => 'Smart waste classification',
                'description' => 'An AI-powered waste classification scanner to help with proper waste sorting and recycling.',
                'category' => 'other',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        // ─── Skills ───────────────────────────────────────
        $designSkills = [
            ['name' => 'Figma', 'level' => 95, 'icon' => '🎨'],
            ['name' => 'Adobe XD', 'level' => 85, 'icon' => '✏️'],
            ['name' => 'Photoshop', 'level' => 80, 'icon' => '🖼️'],
            ['name' => 'Illustrator', 'level' => 75, 'icon' => '🎭'],
        ];

        $devSkills = [
            ['name' => 'HTML/CSS', 'level' => 90, 'icon' => '🌐'],
            ['name' => 'JavaScript', 'level' => 80, 'icon' => '⚡'],
            ['name' => 'Laravel', 'level' => 85, 'icon' => '🔧'],
            ['name' => 'React', 'level' => 70, 'icon' => '⚛️'],
        ];

        $otherSkills = [
            ['name' => 'User Research', 'level' => 90, 'icon' => '🔍'],
            ['name' => 'Prototyping', 'level' => 92, 'icon' => '📐'],
            ['name' => 'Wireframing', 'level' => 88, 'icon' => '📝'],
            ['name' => 'Design Systems', 'level' => 85, 'icon' => '🧩'],
        ];

        $order = 1;
        foreach ($designSkills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                array_merge($skill, ['category' => 'Design', 'sort_order' => $order++, 'is_active' => true])
            );
        }
        foreach ($devSkills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                array_merge($skill, ['category' => 'Development', 'sort_order' => $order++, 'is_active' => true])
            );
        }
        foreach ($otherSkills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                array_merge($skill, ['category' => 'UX', 'sort_order' => $order++, 'is_active' => true])
            );
        }

        // ─── Experiences ──────────────────────────────────
        Experience::updateOrCreate(
            ['title' => 'UI/UX Designer', 'company' => 'Freelance'],
            [
                'location' => 'Indonesia',
                'period' => '2024 - Present',
                'description' => 'Designing user interfaces and experiences for various clients across industries. Specializing in healthcare and enterprise applications.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Experience::updateOrCreate(
            ['title' => 'IT Staff', 'company' => 'Hospital'],
            [
                'location' => 'Indonesia',
                'period' => '2023 - 2024',
                'description' => 'Managed hospital information systems, streamlined digital workflows, and led the SIMRS migration project with a user-centric approach.',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        Experience::updateOrCreate(
            ['title' => 'Information Systems', 'company' => 'University'],
            [
                'location' => 'Indonesia',
                'period' => '2019 - 2023',
                'description' => 'Bachelor degree in Information Systems. Gained foundational knowledge in software development, database management, and system analysis.',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );
    }
}
