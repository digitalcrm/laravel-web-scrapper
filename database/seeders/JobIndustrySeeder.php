<?php

namespace Database\Seeders;

use App\Models\JobFunction;
use App\Models\JobIndustry;
use Illuminate\Database\Seeder;

class JobIndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $job_function = [
            [
                'code'  => '47',
                'groups' => 'corp, fin',
                'name'  => 'Accounting',
            ],
            [
                'code' => '94',
                'groups' => 'man, tech, tran',
                'name' => 'Airlines/Aviation',
            ],
            [
                'code' => '120',
                'groups' => 'leg, org',
                'name' => 'Alternative Dispute Resolution',
            ],
            [
                'code' => '125',
                'groups' => 'hlth',
                'name' => 'Alternative Medicine',
            ],
            [
                'code' => '127',
                'groups' => 'art, med',
                'name' => 'Animation',
            ],
            [
                'code' => '19',
                'groups' => 'good',
                'name' => 'Apparel &amp; Fashion',
            ],
            [
                'code' => '50',
                'groups' => 'cons',
                'name' => 'Architecture &amp; Planning',
            ],
            [
                'code' => '111',
                'groups' => 'art, med, rec',
                'name' => 'Arts and Crafts',
            ],
            [
                'code' => '53',
                'groups' => 'man',
                'name' => 'Automotive',
            ],
            [
                'code' => '52',
                'groups' => 'gov, man',
                'name' => 'Aviation &amp; Aerospace',
            ],
            [
                'code' => '41',
                'groups' => 'fin',
                'name' => 'Banking',
            ],
            [
                'code' => '12',
                'groups' => 'gov, hlth, tech',
                'name' => 'Biotechnology',
            ],
            [
                'code' => '36',
                'groups' => 'med, rec',
                'name' => 'Broadcast Media',
            ],
            [
                'code' => '49',
                'groups' => 'cons',
                'name' => 'Building Materials',
            ],
            [
                'code' => '138',
                'groups' => 'corp, man',
                'name' => 'Business Supplies and Equipment',
            ],
            [
                'code' => '129',
                'groups' => 'fin',
                'name' => 'Capital Markets',
            ],
            [
                'code' => '54',
                'groups' => 'man',
                'name' => 'Chemicals',
            ],
            [
                'code' => '90',
                'groups' => 'org, serv',
                'name' => 'Civic &amp; Social Organization',
            ],
            [
                'code' => '51',
                'groups' => 'cons, gov',
                'name' => 'Civil Engineering',
            ],
            [
                'code' => '128',
                'groups' => 'cons, corp, fin',
                'name' => 'Commercial Real Estate',
            ],
            [
                'code' => '118',
                'groups' => 'tech',
                'name' => 'Computer &amp; Network Security',
            ],
            [
                'code' => '109',
                'groups' => 'med, rec',
                'name' => 'Computer Games',
            ],
            [
                'code' => '3',
                'groups' => 'tech',
                'name' => 'Computer Hardware',
            ],
            [
                'code' => '5',
                'groups' => 'tech',
                'name' => 'Computer Networking',
            ],
            [
                'code' => '4',
                'groups' => 'tech',
                'name' => 'Computer Software',
            ],
            [
                'code' => '48',
                'groups' => 'cons',
                'name' => 'Construction',
            ],
            [
                'code' => '24',
                'groups' => 'good, man',
                'name' => 'Consumer Electronics',
            ],
            [
                'code' => '25',
                'groups' => 'good, man',
                'name' => 'Consumer Goods',
            ],
            [
                'code' => '91',
                'groups' => 'org, serv',
                'name' => 'Consumer Services',
            ],
            [
                'code' => '18',
                'groups' => 'good',
                'name' => 'Cosmetics',
            ],
            [
                'code' => '65',
                'groups' => 'agr',
                'name' => 'Dairy',
            ],
            [
                'code' => '1',
                'groups' => 'gov, tech',
                'name' => 'Defense &amp; Space',
            ],
            [
                'code' => '99',
                'groups' => 'art, med',
                'name' => 'Design',
            ],
            [
                'code' => '69',
                'groups' => 'edu',
                'name' => 'Education Management',
            ],
            [
                'code' => '132',
                'groups' => 'edu, org',
                'name' => 'E-Learning',
            ],
            [
                'code' => '112',
                'groups' => 'good, man',
                'name' => 'Electrical/Electronic Manufacturing',
            ],
            [
                'code' => '28',
                'groups' => 'med, rec',
                'name' => 'Entertainment',
            ],
            [
                'code' => '86',
                'groups' => 'org, serv',
                'name' => 'Environmental Services',
            ],
            [
                'code' => '110',
                'groups' => 'corp, rec, serv',
                'name' => 'Events Services',
            ],
            [
                'code' => '76',
                'groups' => 'gov',
                'name' => 'Executive Office',
            ],
            [
                'code' => '122',
                'groups' => 'corp, serv',
                'name' => 'Facilities Services',
            ],
            [
                'code' => '63',
                'groups' => 'agr',
                'name' => 'Farming',
            ],
            [
                'code' => '43',
                'groups' => 'fin',
                'name' => 'Financial Services',
            ],
            [
                'code' => '38',
                'groups' => 'art, med, rec',
                'name' => 'Fine Art',
            ],
            [
                'code' => '66',
                'groups' => 'agr',
                'name' => 'Fishery',
            ],
            [
                'code' => '34',
                'groups' => 'rec, serv',
                'name' => 'Food &amp; Beverages',
            ],
            [
                'code' => '23',
                'groups' => 'good, man, serv',
                'name' => 'Food Production',
            ],
            [
                'code' => '101',
                'groups' => 'org',
                'name' => 'Fund-Raising',
            ],
            [
                'code' => '26',
                'groups' => 'good, man',
                'name' => 'Furniture',
            ],
            [
                'code' => '29',
                'groups' => 'rec',
                'name' => 'Gambling &amp; Casinos',
            ],
            [
                'code' => '145',
                'groups' => 'cons, man',
                'name' => 'Glass, Ceramics &amp; Concrete',
            ],
            [
                'code' => '75',
                'groups' => 'gov',
                'name' => 'Government Administration',
            ],
            [
                'code' => '148',
                'groups' => 'gov',
                'name' => 'Government Relations',
            ],
            [
                'code' => '140',
                'groups' => 'art, med',
                'name' => 'Graphic Design',
            ],
            [
                'code' => '124',
                'groups' => 'hlth, rec',
                'name' => 'Health, Wellness and Fitness',
            ],
            [
                'code' => '68',
                'groups' => 'edu',
                'name' => 'Higher Education',
            ],
            [
                'code' => '14',
                'groups' => 'hlth',
                'name' => 'Hospital &amp; Health Care',
            ],
            [
                'code' => '31',
                'groups' => 'rec, serv, tran',
                'name' => 'Hospitality',
            ],
            [
                'code' => '137',
                'groups' => 'corp',
                'name' => 'Human Resources',
            ],
            [
                'code' => '134',
                'groups' => 'corp, good, tran',
                'name' => 'Import and Export',
            ],
            [
                'code' => '88',
                'groups' => 'org, serv',
                'name' => 'Individual &amp; Family Services',
            ],
            [
                'code' => '147',
                'groups' => 'cons, man',
                'name' => 'Industrial Automation',
            ],
            [
                'code' => '84',
                'groups' => 'med, serv',
                'name' => 'Information Services',
            ],
            [
                'code' => '96',
                'groups' => 'tech',
                'name' => 'Information Technology and Services',
            ],
            [
                'code' => '42',
                'groups' => 'fin',
                'name' => 'Insurance',
            ],
            [
                'code' => '74',
                'groups' => 'gov',
                'name' => 'International Affairs',
            ],
            [
                'code' => '141',
                'groups' => 'gov, org, tran',
                'name' => 'International Trade and Development',
            ],
            [
                'code' => '6',
                'groups' => 'tech',
                'name' => 'Internet',
            ],
            [
                'code' => '45',
                'groups' => 'fin',
                'name' => 'Investment Banking',
            ],
            [
                'code' => '46',
                'groups' => 'fin',
                'name' => 'Investment Management',
            ],
            [
                'code' => '73',
                'groups' => 'gov, leg',
                'name' => 'Judiciary',
            ],
            [
                'code' => '77',
                'groups' => 'gov, leg',
                'name' => 'Law Enforcement',
            ],
            [
                'code' => '9',
                'groups' => 'leg',
                'name' => 'Law Practice',
            ],
            [
                'code' => '10',
                'groups' => 'leg',
                'name' => 'Legal Services',
            ],
            [
                'code' => '72',
                'groups' => 'gov, leg',
                'name' => 'Legislative Office',
            ],
            [
                'code' => '30',
                'groups' => 'rec, serv, tran',
                'name' => 'Leisure, Travel &amp; Tourism',
            ],
            [
                'code' => '85',
                'groups' => 'med, rec, serv',
                'name' => 'Libraries',
            ],
            [
                'code' => '116',
                'groups' => 'corp, tran',
                'name' => 'Logistics and Supply Chain',
            ],
            [
                'code' => '143',
                'groups' => 'good',
                'name' => 'Luxury Goods &amp; Jewelry',
            ],
            [
                'code' => '55',
                'groups' => 'man',
                'name' => 'Machinery',
            ],
            [
                'code' => '11',
                'groups' => 'corp',
                'name' => 'Management Consulting',
            ],
            [
                'code' => '95',
                'groups' => 'tran',
                'name' => 'Maritime',
            ],
            [
                'code' => '97',
                'groups' => 'corp',
                'name' => 'Market Research',
            ],
            [
                'code' => '80',
                'groups' => 'corp, med',
                'name' => 'Marketing and Advertising',
            ],
            [
                'code' => '135',
                'groups' => 'cons, gov, man',
                'name' => 'Mechanical or Industrial Engineering',
            ],
            [
                'code' => '126',
                'groups' => 'med, rec',
                'name' => 'Media Production',
            ],
            [
                'code' => '17',
                'groups' => 'hlth',
                'name' => 'Medical Devices',
            ],
            [
                'code' => '13',
                'groups' => 'hlth',
                'name' => 'Medical Practice',
            ],
            [
                'code' => '139',
                'groups' => 'hlth',
                'name' => 'Mental Health Care',
            ],
            [
                'code' => '71',
                'groups' => 'gov',
                'name' => 'Military',
            ],
            [
                'code' => '56',
                'groups' => 'man',
                'name' => 'Mining &amp; Metals',
            ],
            [
                'code' => '35',
                'groups' => 'art, med, rec',
                'name' => 'Motion Pictures and Film',
            ],
            [
                'code' => '37',
                'groups' => 'art, med, rec',
                'name' => 'Museums and Institutions',
            ],
            [
                'code' => '115',
                'groups' => 'art, rec',
                'name' => 'Music',
            ],
            [
                'code' => '114',
                'groups' => 'gov, man, tech',
                'name' => 'Nanotechnology',
            ],
            [
                'code' => '81',
                'groups' => 'med, rec',
                'name' => 'Newspapers',
            ],
            [
                'code' => '100',
                'groups' => 'org',
                'name' => 'Non-Profit Organization Management',
            ],
            [
                'code' => '57',
                'groups' => 'man',
                'name' => 'Oil &amp; Energy',
            ],
            [
                'code' => '113',
                'groups' => 'med',
                'name' => 'Online Media',
            ],
            [
                'code' => '123',
                'groups' => 'corp',
                'name' => 'Outsourcing/Offshoring',
            ],
            [
                'code' => '87',
                'groups' => 'serv, tran',
                'name' => 'Package/Freight Delivery',
            ],
            [
                'code' => '146',
                'groups' => 'good, man',
                'name' => 'Packaging and Containers',
            ],
            [
                'code' => '61',
                'groups' => 'man',
                'name' => 'Paper &amp; Forest Products',
            ],
            [
                'code' => '39',
                'groups' => 'art, med, rec',
                'name' => 'Performing Arts',
            ],
            [
                'code' => '15',
                'groups' => 'hlth, tech',
                'name' => 'Pharmaceuticals',
            ],
            [
                'code' => '131',
                'groups' => 'org',
                'name' => 'Philanthropy',
            ],
            [
                'code' => '136',
                'groups' => 'art, med, rec',
                'name' => 'Photography',
            ],
            [
                'code' => '117',
                'groups' => 'man',
                'name' => 'Plastics',
            ],
            [
                'code' => '107',
                'groups' => 'gov, org',
                'name' => 'Political Organization',
            ],
            [
                'code' => '67',
                'groups' => 'edu',
                'name' => 'Primary/Secondary Education',
            ],
            [
                'code' => '83',
                'groups' => 'med, rec',
                'name' => 'Printing',
            ],
            [
                'code' => '105',
                'groups' => 'corp',
                'name' => 'Professional Training &amp; Coaching',
            ],
            [
                'code' => '102',
                'groups' => 'corp, org',
                'name' => 'Program Development',
            ],
            [
                'code' => '79',
                'groups' => 'gov',
                'name' => 'Public Policy',
            ],
            [
                'code' => '98',
                'groups' => 'corp',
                'name' => 'Public Relations and Communications',
            ],
            [
                'code' => '78',
                'groups' => 'gov',
                'name' => 'Public Safety',
            ],
            [
                'code' => '82',
                'groups' => 'med, rec',
                'name' => 'Publishing',
            ],
            [
                'code' => '62',
                'groups' => 'man',
                'name' => 'Railroad Manufacture',
            ],
            [
                'code' => '64',
                'groups' => 'agr',
                'name' => 'Ranching',
            ],
            [
                'code' => '44',
                'groups' => 'cons, fin, good',
                'name' => 'Real Estate',
            ],
            [
                'code' => '40',
                'groups' => 'rec, serv',
                'name' => 'Recreational Facilities and Services',
            ],
            [
                'code' => '89',
                'groups' => 'org, serv',
                'name' => 'Religious Institutions',
            ],
            [
                'code' => '144',
                'groups' => 'gov, man, org',
                'name' => 'Renewables &amp; Environment',
            ],
            [
                'code' => '70',
                'groups' => 'edu, gov',
                'name' => 'Research',
            ],
            [
                'code' => '32',
                'groups' => 'rec, serv',
                'name' => 'Restaurants',
            ],
            [
                'code' => '27',
                'groups' => 'good, man',
                'name' => 'Retail',
            ],
            [
                'code' => '121',
                'groups' => 'corp, org, serv',
                'name' => 'Security and Investigations',
            ],
            [
                'code' => '7',
                'groups' => 'tech',
                'name' => 'Semiconductors',
            ],
            [
                'code' => '58',
                'groups' => 'man',
                'name' => 'Shipbuilding',
            ],
            [
                'code' => '20',
                'groups' => 'good, rec',
                'name' => 'Sporting Goods',
            ],
            [
                'code' => '33',
                'groups' => 'rec',
                'name' => 'Sports',
            ],
            [
                'code' => '104',
                'groups' => 'corp',
                'name' => 'Staffing and Recruiting',
            ],
            [
                'code' => '22',
                'groups' => 'good',
                'name' => 'Supermarkets',
            ],
            [
                'code' => '8',
                'groups' => 'gov, tech',
                'name' => 'Telecommunications',
            ],
            [
                'code' => '60',
                'groups' => 'man',
                'name' => 'Textiles',
            ],
            [
                'code' => '130',
                'groups' => 'gov, org',
                'name' => 'Think Tanks',
            ],
            [
                'code' => '21',
                'groups' => 'good',
                'name' => 'Tobacco',
            ],
            [
                'code' => '108',
                'groups' => 'corp, gov, serv',
                'name' => 'Translation and Localization',
            ],
            [
                'code' => '92',
                'groups' => 'tran',
                'name' => 'Transportation/Trucking/Railroad',
            ],
            [
                'code' => '59',
                'groups' => 'man',
                'name' => 'Utilities',
            ],
            [
                'code' => '106',
                'groups' => 'fin, tech',
                'name' => 'Venture Capital &amp; Private Equity',
            ],
            [
                'code' => '16',
                'groups' => 'hlth',
                'name' => 'Veterinary',
            ],
            [
                'code' => '93',
                'groups' => 'tran',
                'name' => 'Warehousing',
            ],
            [
                'code' => '133',
                'groups' => 'good',
                'name' => 'Wholesale',
            ],
            [
                'code' => '142',
                'groups' => 'good, man, rec',
                'name' => 'Wine and Spirits',
            ],
            [
                'code' => '119',
                'groups' => 'tech',
                'name' => 'Wireless',
            ],
            [
                'code' => '103',
                'groups' => 'art, med, rec',
                'name' => 'Writing and Editing',
            ],
        ];

        collect($job_function)->each(function ($value) {
            JobIndustry::create($value);
        });
    }
}
