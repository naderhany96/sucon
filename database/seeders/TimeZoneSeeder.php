<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeZones = [
            [
                'id' => 1,
                'name' => 'UTC'
            ],
            [
                'id' => 2,
                'name' => 'Africa/Cairo'
            ],
            [
                'id' => 3,
                'name' => 'Asia/Amman'
            ],
            [
                "id" => 4,
                "name" => "Africa/Abidjan"
            ],
            [
                "id" => 5,
                "name" => "Africa/Accra"
            ],
            [
                "id" => 6,
                "name" => "Africa/Addis_Ababa"
            ],
            [
                "id" => 7,
                "name" => "Africa/Algiers"
            ],
            [
                "id" => 8,
                "name" => "Africa/Asmara"
            ],
            [
                "id" => 9,
                "name" => "Africa/Bamako"
            ],
            [
                "id" => 10,
                "name" => "Africa/Bangui"
            ],
            [
                "id" => 11,
                "name" => "Africa/Banjul"
            ],
            [
                "id" => 12,
                "name" => "Africa/Bissau"
            ],
            [
                "id" => 13,
                "name" => "Africa/Blantyre"
            ],
            [
                "id" => 14,
                "name" => "Africa/Brazzaville"
            ],
            [
                "id" => 15,
                "name" => "Africa/Bujumbura"
            ],
            [
                "id" => 16,
                "name" => "Africa/Dakar"
            ],
            [
                "id" => 17,
                "name" => "Africa/Dar_es_Salaam"
            ],
            [
                "id" => 18,
                "name" => "Africa/Djibouti"
            ],
            [
                "id" => 19,
                "name" => "Africa/Douala"
            ],
            [
                "id" => 20,
                "name" => "Africa/El_Aaiun"
            ],
            [
                "id" => 21,
                "name" => "Africa/Freetown"
            ],
            [
                "id" => 22,
                "name" => "Africa/Gaborone"
            ],
            [
                "id" => 23,
                "name" => "Africa/Harare"
            ],
            [
                "id" => 24,
                "name" => "Africa/Johannesburg"
            ],
            [
                "id" => 25,
                "name" => "Africa/Juba"
            ],
            [
                "id" => 26,
                "name" => "Africa/Kampala"
            ],
            [
                "id" => 27,
                "name" => "Africa/Khartoum"
            ],
            [
                "id" => 28,
                "name" => "Africa/Kigali"
            ],
            [
                "id" => 29,
                "name" => "Africa/Kinshasa"
            ],
            [
                "id" => 30,
                "name" => "Africa/Lagos"
            ],
            [
                "id" => 31,
                "name" => "Africa/Libreville"
            ],
            [
                "id" => 32,
                "name" => "Africa/Lome"
            ],
            [
                "id" => 33,
                "name" => "Africa/Luanda"
            ],
            [
                "id" => 34,
                "name" => "Africa/Lubumbashi"
            ],
            [
                "id" => 35,
                "name" => "Africa/Lusaka"
            ],
            [
                "id" => 36,
                "name" => "Africa/Malabo"
            ],
            [
                "id" => 37,
                "name" => "Africa/Maputo"
            ],
            [
                "id" => 38,
                "name" => "Africa/Maseru"
            ],
            [
                "id" => 39,
                "name" => "Africa/Mbabane"
            ],
            [
                "id" => 40,
                "name" => "Africa/Mogadishu"
            ],
            [
                "id" => 41,
                "name" => "Africa/Monrovia"
            ],
            [
                "id" => 42,
                "name" => "Africa/Nairobi"
            ],
            [
                "id" => 43,
                "name" => "Africa/Ndjamena"
            ],
            [
                "id" => 44,
                "name" => "Africa/Niamey"
            ],
            [
                "id" => 45,
                "name" => "Africa/Nouakchott"
            ],
            [
                "id" => 46,
                "name" => "Africa/Ouagadougou"
            ],
            [
                "id" => 47,
                "name" => "Africa/Porto-Novo"
            ],
            [
                "id" => 48,
                "name" => "Africa/Sao_Tome"
            ],
            [
                "id" => 49,
                "name" => "Africa/Tripoli"
            ],
            [
                "id" => 50,
                "name" => "Africa/Tunis"
            ],
            [
                "id" => 51,
                "name" => "Africa/Windhoek"
            ],
            [
                "id" => 52,
                "name" => "America/Adak"
            ],
            [
                "id" => 53,
                "name" => "America/Anchorage"
            ],
            [
                "id" => 54,
                "name" => "America/Anguilla"
            ],
            [
                "id" => 55,
                "name" => "America/Antigua"
            ],
            [
                "id" => 56,
                "name" => "America/Araguaina"
            ],
            [
                "id" => 57,
                "name" => "America/Argentina/Buenos_Aires"
            ],
            [
                "id" => 58,
                "name" => "America/Argentina/Catamarca"
            ],
            [
                "id" => 59,
                "name" => "America/Argentina/Cordoba"
            ],
            [
                "id" => 60,
                "name" => "America/Argentina/Jujuy"
            ],
            [
                "id" => 61,
                "name" => "America/Argentina/La_Rioja"
            ],
            [
                "id" => 62,
                "name" => "America/Argentina/Mendoza"
            ],
            [
                "id" => 63,
                "name" => "America/Argentina/Rio_Gallegos"
            ],
            [
                "id" => 64,
                "name" => "America/Argentina/Salta"
            ],
            [
                "id" => 65,
                "name" => "America/Argentina/San_Juan"
            ],
            [
                "id" => 66,
                "name" => "America/Argentina/San_Luis"
            ],
            [
                "id" => 67,
                "name" => "America/Argentina/Tucuman"
            ],
            [
                "id" => 68,
                "name" => "America/Argentina/Ushuaia"
            ],
            [
                "id" => 69,
                "name" => "America/Aruba"
            ],
            [
                "id" => 70,
                "name" => "America/Asuncion"
            ],
            [
                "id" => 71,
                "name" => "America/Atikokan"
            ],
            [
                "id" => 72,
                "name" => "America/Bahia"
            ],
            [
                "id" => 73,
                "name" => "America/Bahia_Banderas"
            ],
            [
                "id" => 74,
                "name" => "America/Barbados"
            ],
            [
                "id" => 75,
                "name" => "America/Belem"
            ],
            [
                "id" => 76,
                "name" => "America/Belize"
            ],
            [
                "id" => 77,
                "name" => "America/Blanc-Sablon"
            ],
            [
                "id" => 78,
                "name" => "America/Boa_Vista"
            ],
            [
                "id" => 79,
                "name" => "America/Bogota"
            ],
            [
                "id" => 80,
                "name" => "America/Boise"
            ],
            [
                "id" => 81,
                "name" => "America/Cambridge_Bay"
            ],
            [
                "id" => 82,
                "name" => "America/Campo_Grande"
            ],
            [
                "id" => 83,
                "name" => "America/Cancun"
            ],
            [
                "id" => 84,
                "name" => "America/Caracas"
            ],
            [
                "id" => 85,
                "name" => "America/Cayenne"
            ],
            [
                "id" => 86,
                "name" => "America/Cayman"
            ],
            [
                "id" => 87,
                "name" => "America/Chicago"
            ],
            [
                "id" => 88,
                "name" => "America/Chihuahua"
            ],
            [
                "id" => 89,
                "name" => "America/Ciudad_Juarez"
            ],
            [
                "id" => 90,
                "name" => "America/Costa_Rica"
            ],
            [
                "id" => 91,
                "name" => "America/Creston"
            ],
            [
                "id" => 92,
                "name" => "America/Cuiaba"
            ],
            [
                "id" => 93,
                "name" => "America/Curacao"
            ],
            [
                "id" => 94,
                "name" => "America/Danmarkshavn"
            ],
            [
                "id" => 95,
                "name" => "America/Dawson"
            ],
            [
                "id" => 96,
                "name" => "America/Dawson_Creek"
            ],
            [
                "id" => 97,
                "name" => "America/Denver"
            ],
            [
                "id" => 98,
                "name" => "America/Detroit"
            ],
            [
                "id" => 99,
                "name" => "America/Dominica"
            ],
            [
                "id" => 100,
                "name" => "America/Edmonton"
            ],
            [
                "id" => 101,
                "name" => "America/Eirunepe"
            ],
            [
                "id" => 102,
                "name" => "America/El_Salvador"
            ],
            [
                "id" => 103,
                "name" => "America/Fort_Nelson"
            ],
            [
                "id" => 104,
                "name" => "America/Fortaleza"
            ],
            [
                "id" => 105,
                "name" => "America/Glace_Bay"
            ],
            [
                "id" => 106,
                "name" => "America/Goose_Bay"
            ],
            [
                "id" => 107,
                "name" => "America/Grand_Turk"
            ],
            [
                "id" => 108,
                "name" => "America/Grenada"
            ],
            [
                "id" => 109,
                "name" => "America/Guadeloupe"
            ],
            [
                "id" => 110,
                "name" => "America/Guatemala"
            ],
            [
                "id" => 111,
                "name" => "America/Guayaquil"
            ],
            [
                "id" => 112,
                "name" => "America/Guyana"
            ],
            [
                "id" => 113,
                "name" => "America/Halifax"
            ],
            [
                "id" => 114,
                "name" => "America/Havana"
            ],
            [
                "id" => 115,
                "name" => "America/Hermosillo"
            ],
            [
                "id" => 116,
                "name" => "America/Indiana/Indianapolis"
            ],
            [
                "id" => 117,
                "name" => "America/Indiana/Knox"
            ],
            [
                "id" => 118,
                "name" => "America/Indiana/Marengo"
            ],
            [
                "id" => 119,
                "name" => "America/Indiana/Petersburg"
            ],
            [
                "id" => 120,
                "name" => "America/Indiana/Tell_City"
            ],
            [
                "id" => 121,
                "name" => "America/Indiana/Vevay"
            ],
            [
                "id" => 122,
                "name" => "America/Indiana/Vincennes"
            ],
            [
                "id" => 123,
                "name" => "America/Indiana/Winamac"
            ],
            [
                "id" => 124,
                "name" => "America/Inuvik"
            ],
            [
                "id" => 125,
                "name" => "America/Iqaluit"
            ],
            [
                "id" => 126,
                "name" => "America/Jamaica"
            ],
            [
                "id" => 127,
                "name" => "America/Juneau"
            ],
            [
                "id" => 128,
                "name" => "America/Kentucky/Louisville"
            ],
            [
                "id" => 129,
                "name" => "America/Kentucky/Monticello"
            ],
            [
                "id" => 130,
                "name" => "America/Kralendijk"
            ],
            [
                "id" => 131,
                "name" => "America/La_Paz"
            ],
            [
                "id" => 132,
                "name" => "America/Lima"
            ],
            [
                "id" => 133,
                "name" => "America/Los_Angeles"
            ],
            [
                "id" => 134,
                "name" => "America/Lower_Princes"
            ],
            [
                "id" => 135,
                "name" => "America/Maceio"
            ],
            [
                "id" => 136,
                "name" => "America/Managua"
            ],
            [
                "id" => 137,
                "name" => "America/Manaus"
            ],
            [
                "id" => 138,
                "name" => "America/Marigot"
            ],
            [
                "id" => 139,
                "name" => "America/Martinique"
            ],
            [
                "id" => 140,
                "name" => "America/Matamoros"
            ],
            [
                "id" => 141,
                "name" => "America/Mazatlan"
            ],
            [
                "id" => 142,
                "name" => "America/Menominee"
            ],
            [
                "id" => 143,
                "name" => "America/Merida"
            ],
            [
                "id" => 144,
                "name" => "America/Metlakatla"
            ],
            [
                "id" => 145,
                "name" => "America/Mexico_City"
            ],
            [
                "id" => 146,
                "name" => "America/Miquelon"
            ],
            [
                "id" => 147,
                "name" => "America/Moncton"
            ],
            [
                "id" => 148,
                "name" => "America/Monterrey"
            ],
            [
                "id" => 149,
                "name" => "America/Montevideo"
            ],
            [
                "id" => 150,
                "name" => "America/Montserrat"
            ],
            [
                "id" => 151,
                "name" => "America/Nassau"
            ],
            [
                "id" => 152,
                "name" => "America/New_York"
            ],
            [
                "id" => 153,
                "name" => "America/Nome"
            ],
            [
                "id" => 154,
                "name" => "America/Noronha"
            ],
            [
                "id" => 155,
                "name" => "America/North_Dakota/Beulah"
            ],
            [
                "id" => 156,
                "name" => "America/North_Dakota/Center"
            ],
            [
                "id" => 157,
                "name" => "America/North_Dakota/New_Salem"
            ],
            [
                "id" => 158,
                "name" => "America/Nuuk"
            ],
            [
                "id" => 159,
                "name" => "America/Ojinaga"
            ],
            [
                "id" => 160,
                "name" => "America/Panama"
            ],
            [
                "id" => 161,
                "name" => "America/Paramaribo"
            ],
            [
                "id" => 162,
                "name" => "America/Phoenix"
            ],
            [
                "id" => 163,
                "name" => "America/Port-au-Prince"
            ],
            [
                "id" => 164,
                "name" => "America/Port_of_Spain"
            ],
            [
                "id" => 165,
                "name" => "America/Porto_Velho"
            ],
            [
                "id" => 166,
                "name" => "America/Puerto_Rico"
            ],
            [
                "id" => 167,
                "name" => "America/Punta_Arenas"
            ],
            [
                "id" => 168,
                "name" => "America/Rankin_Inlet"
            ],
            [
                "id" => 169,
                "name" => "America/Recife"
            ],
            [
                "id" => 170,
                "name" => "America/Regina"
            ],
            [
                "id" => 171,
                "name" => "America/Resolute"
            ],
            [
                "id" => 172,
                "name" => "America/Rio_Branco"
            ],
            [
                "id" => 173,
                "name" => "America/Santarem"
            ],
            [
                "id" => 174,
                "name" => "America/Santiago"
            ],
            [
                "id" => 175,
                "name" => "America/Santo_Domingo"
            ],
            [
                "id" => 176,
                "name" => "America/Sao_Paulo"
            ],
            [
                "id" => 177,
                "name" => "America/Scoresbysund"
            ],
            [
                "id" => 178,
                "name" => "America/Sitka"
            ],
            [
                "id" => 179,
                "name" => "America/St_Barthelemy"
            ],
            [
                "id" => 180,
                "name" => "America/St_Johns"
            ],
            [
                "id" => 181,
                "name" => "America/St_Kitts"
            ],
            [
                "id" => 182,
                "name" => "America/St_Lucia"
            ],
            [
                "id" => 183,
                "name" => "America/St_Thomas"
            ],
            [
                "id" => 184,
                "name" => "America/St_Vincent"
            ],
            [
                "id" => 185,
                "name" => "America/Swift_Current"
            ],
            [
                "id" => 186,
                "name" => "America/Tegucigalpa"
            ],
            [
                "id" => 187,
                "name" => "America/Thule"
            ],
            [
                "id" => 188,
                "name" => "America/Tijuana"
            ],
            [
                "id" => 189,
                "name" => "America/Toronto"
            ],
            [
                "id" => 190,
                "name" => "America/Tortola"
            ],
            [
                "id" => 191,
                "name" => "America/Vancouver"
            ],
            [
                "id" => 192,
                "name" => "America/Whitehorse"
            ],
            [
                "id" => 193,
                "name" => "America/Winnipeg"
            ],
            [
                "id" => 194,
                "name" => "America/Yakutat"
            ],
            [
                "id" => 195,
                "name" => "Asia/Aqtau"
            ],
            [
                "id" => 196,
                "name" => "Asia/Aqtobe"
            ],
            [
                "id" => 197,
                "name" => "Asia/Ashgabat"
            ],
            [
                "id" => 198,
                "name" => "Asia/Atyrau"
            ],
            [
                "id" => 199,
                "name" => "Asia/Baghdad"
            ],
            [
                "id" => 200,
                "name" => "Asia/Bahrain"
            ],
            [
                "id" => 201,
                "name" => "Asia/Baku"
            ],
            [
                "id" => 202,
                "name" => "Asia/Bangkok"
            ],
            [
                "id" => 203,
                "name" => "Asia/Barnaul"
            ],
            [
                "id" => 204,
                "name" => "Asia/Beirut"
            ],
            [
                "id" => 205,
                "name" => "Asia/Bishkek"
            ],
            [
                "id" => 206,
                "name" => "Asia/Brunei"
            ],
            [
                "id" => 207,
                "name" => "Asia/Chita"
            ],
            [
                "id" => 208,
                "name" => "Asia/Choibalsan"
            ],
            [
                "id" => 209,
                "name" => "Asia/Colombo"
            ],
            [
                "id" => 210,
                "name" => "Asia/Damascus"
            ],
            [
                "id" => 211,
                "name" => "Asia/Dhaka"
            ],
            [
                "id" => 212,
                "name" => "Asia/Dili"
            ],
            [
                "id" => 213,
                "name" => "Asia/Dubai"
            ],
            [
                "id" => 214,
                "name" => "Asia/Dushanbe"
            ],
            [
                "id" => 215,
                "name" => "Asia/Famagusta"
            ],
            [
                "id" => 216,
                "name" => "Asia/Gaza"
            ],
            [
                "id" => 217,
                "name" => "Asia/Hebron"
            ],
            [
                "id" => 218,
                "name" => "Asia/Ho_Chi_Minh"
            ],
            [
                "id" => 219,
                "name" => "Asia/Hong_Kong"
            ],
            [
                "id" => 220,
                "name" => "Asia/Hovd"
            ],
            [
                "id" => 221,
                "name" => "Asia/Irkutsk"
            ],
            [
                "id" => 222,
                "name" => "Asia/Jakarta"
            ],
            [
                "id" => 223,
                "name" => "Asia/Jayapura"
            ],
            [
                "id" => 224,
                "name" => "Asia/Jerusalem"
            ],
            [
                "id" => 225,
                "name" => "Asia/Kabul"
            ],
            [
                "id" => 226,
                "name" => "Asia/Kamchatka"
            ],
            [
                "id" => 227,
                "name" => "Asia/Karachi"
            ],
            [
                "id" => 228,
                "name" => "Asia/Kathmandu"
            ],
            [
                "id" => 229,
                "name" => "Asia/Khandyga"
            ],
            [
                "id" => 230,
                "name" => "Asia/Kolkata"
            ],
            [
                "id" => 231,
                "name" => "Asia/Krasnoyarsk"
            ],
            [
                "id" => 232,
                "name" => "Asia/Kuala_Lumpur"
            ],
            [
                "id" => 233,
                "name" => "Asia/Kuching"
            ],
            [
                "id" => 234,
                "name" => "Asia/Kuwait"
            ],
            [
                "id" => 235,
                "name" => "Asia/Macau"
            ],
            [
                "id" => 236,
                "name" => "Asia/Magadan"
            ],
            [
                "id" => 237,
                "name" => "Asia/Makassar"
            ],
            [
                "id" => 238,
                "name" => "Asia/Manila"
            ],
            [
                "id" => 239,
                "name" => "Asia/Muscat"
            ],
            [
                "id" => 240,
                "name" => "Asia/Nicosia"
            ],
            [
                "id" => 241,
                "name" => "Asia/Novokuznetsk"
            ],
            [
                "id" => 242,
                "name" => "Asia/Novosibirsk"
            ],
            [
                "id" => 243,
                "name" => "Asia/Omsk"
            ],
            [
                "id" => 244,
                "name" => "Asia/Oral"
            ],
            [
                "id" => 245,
                "name" => "Asia/Phnom_Penh"
            ],
            [
                "id" => 246,
                "name" => "Asia/Pontianak"
            ],
            [
                "id" => 247,
                "name" => "Asia/Pyongyang"
            ],
            [
                "id" => 248,
                "name" => "Asia/Qatar"
            ],
            [
                "id" => 249,
                "name" => "Asia/Qostanay"
            ],
            [
                "id" => 250,
                "name" => "Asia/Qyzylorda"
            ],
            [
                "id" => 251,
                "name" => "Asia/Riyadh"
            ],
            [
                "id" => 252,
                "name" => "Asia/Sakhalin"
            ],
            [
                "id" => 253,
                "name" => "Asia/Samarkand"
            ],
            [
                "id" => 254,
                "name" => "Asia/Seoul"
            ],
            [
                "id" => 255,
                "name" => "Asia/Shanghai"
            ],
            [
                "id" => 256,
                "name" => "Asia/Singapore"
            ],
            [
                "id" => 257,
                "name" => "Asia/Srednekolymsk"
            ],
            [
                "id" => 258,
                "name" => "Asia/Taipei"
            ],
            [
                "id" => 259,
                "name" => "Asia/Tashkent"
            ],
            [
                "id" => 260,
                "name" => "Asia/Tbilisi"
            ],
            [
                "id" => 261,
                "name" => "Asia/Tehran"
            ],
            [
                "id" => 262,
                "name" => "Asia/Thimphu"
            ],
            [
                "id" => 263,
                "name" => "Asia/Tokyo"
            ],
            [
                "id" => 264,
                "name" => "Asia/Tomsk"
            ],
            [
                "id" => 265,
                "name" => "Asia/Ulaanbaatar"
            ],
            [
                "id" => 266,
                "name" => "Asia/Urumqi"
            ],
            [
                "id" => 267,
                "name" => "Asia/Ust-Nera"
            ],
            [
                "id" => 268,
                "name" => "Asia/Vientiane"
            ],
            [
                "id" => 269,
                "name" => "Asia/Vladivostok"
            ],
            [
                "id" => 270,
                "name" => "Asia/Yakutsk"
            ],
            [
                "id" => 271,
                "name" => "Asia/Yangon"
            ],
            [
                "id" => 272,
                "name" => "Asia/Yekaterinburg"
            ],
            [
                "id" => 273,
                "name" => "Asia/Yerevan"
            ],
            [
                "id" => 274,
                "name" => "Australia/Adelaide"
            ],
            [
                "id" => 275,
                "name" => "Australia/Brisbane"
            ],
            [
                "id" => 276,
                "name" => "Australia/Broken_Hill"
            ],
            [
                "id" => 277,
                "name" => "Australia/Darwin"
            ],
            [
                "id" => 278,
                "name" => "Australia/Eucla"
            ],
            [
                "id" => 279,
                "name" => "Australia/Hobart"
            ],
            [
                "id" => 280,
                "name" => "Australia/Lindeman"
            ],
            [
                "id" => 281,
                "name" => "Australia/Lord_Howe"
            ],
            [
                "id" => 282,
                "name" => "Australia/Melbourne"
            ],
            [
                "id" => 283,
                "name" => "Australia/Perth"
            ],
            [
                "id" => 284,
                "name" => "Australia/Sydney"
            ],
            [
                "id" => 285,
                "name" => "Europe/Amsterdam"
            ],
            [
                "id" => 286,
                "name" => "Europe/Andorra"
            ],
            [
                "id" => 287,
                "name" => "Europe/Astrakhan"
            ],
            [
                "id" => 288,
                "name" => "Europe/Athens"
            ],
            [
                "id" => 289,
                "name" => "Europe/Belgrade"
            ],
            [
                "id" => 290,
                "name" => "Europe/Berlin"
            ],
            [
                "id" => 291,
                "name" => "Europe/Bratislava"
            ],
            [
                "id" => 292,
                "name" => "Europe/Brussels"
            ],
            [
                "id" => 293,
                "name" => "Europe/Bucharest"
            ],
            [
                "id" => 294,
                "name" => "Europe/Budapest"
            ],
            [
                "id" => 295,
                "name" => "Europe/Busingen"
            ],
            [
                "id" => 296,
                "name" => "Europe/Chisinau"
            ],
            [
                "id" => 297,
                "name" => "Europe/Copenhagen"
            ],
            [
                "id" => 298,
                "name" => "Europe/Dublin"
            ],
            [
                "id" => 299,
                "name" => "Europe/Gibraltar"
            ],
            [
                "id" => 300,
                "name" => "Europe/Guernsey"
            ],
            [
                "id" => 301,
                "name" => "Europe/Helsinki"
            ],
            [
                "id" => 302,
                "name" => "Europe/Isle_of_Man"
            ],
            [
                "id" => 303,
                "name" => "Europe/Istanbul"
            ],
            [
                "id" => 304,
                "name" => "Europe/Jersey"
            ],
            [
                "id" => 305,
                "name" => "Europe/Kaliningrad"
            ],
            [
                "id" => 306,
                "name" => "Europe/Kirov"
            ],
            [
                "id" => 307,
                "name" => "Europe/Kyiv"
            ],
            [
                "id" => 308,
                "name" => "Europe/Lisbon"
            ],
            [
                "id" => 309,
                "name" => "Europe/Ljubljana"
            ],
            [
                "id" => 310,
                "name" => "Europe/London"
            ],
            [
                "id" => 311,
                "name" => "Europe/Luxembourg"
            ],
            [
                "id" => 312,
                "name" => "Europe/Madrid"
            ],
            [
                "id" => 313,
                "name" => "Europe/Malta"
            ],
            [
                "id" => 314,
                "name" => "Europe/Mariehamn"
            ],
            [
                "id" => 315,
                "name" => "Europe/Minsk"
            ],
            [
                "id" => 316,
                "name" => "Europe/Monaco"
            ],
            [
                "id" => 317,
                "name" => "Europe/Moscow"
            ],
            [
                "id" => 318,
                "name" => "Europe/Oslo"
            ],
            [
                "id" => 319,
                "name" => "Europe/Paris"
            ],
            [
                "id" => 320,
                "name" => "Europe/Podgorica"
            ],
            [
                "id" => 321,
                "name" => "Europe/Prague"
            ],
            [
                "id" => 322,
                "name" => "Europe/Riga"
            ],
            [
                "id" => 323,
                "name" => "Europe/Rome"
            ],
            [
                "id" => 324,
                "name" => "Europe/Samara"
            ],
            [
                "id" => 325,
                "name" => "Europe/San_Marino"
            ],
            [
                "id" => 326,
                "name" => "Europe/Sarajevo"
            ],
            [
                "id" => 327,
                "name" => "Europe/Saratov"
            ],
            [
                "id" => 328,
                "name" => "Europe/Simferopol"
            ],
            [
                "id" => 329,
                "name" => "Europe/Skopje"
            ],
            [
                "id" => 330,
                "name" => "Europe/Sofia"
            ],
            [
                "id" => 331,
                "name" => "Europe/Stockholm"
            ],
            [
                "id" => 332,
                "name" => "Europe/Tallinn"
            ],
            [
                "id" => 333,
                "name" => "Europe/Tirane"
            ],
            [
                "id" => 334,
                "name" => "Europe/Ulyanovsk"
            ],
            [
                "id" => 335,
                "name" => "Europe/Vaduz"
            ],
            [
                "id" => 336,
                "name" => "Europe/Vatican"
            ],
            [
                "id" => 337,
                "name" => "Europe/Vienna"
            ],
            [
                "id" => 338,
                "name" => "Europe/Vilnius"
            ],
            [
                "id" => 339,
                "name" => "Europe/Volgograd"
            ],
            [
                "id" => 340,
                "name" => "Europe/Warsaw"
            ],
            [
                "id" => 341,
                "name" => "Europe/Zagreb"
            ],
            [
                "id" => 342,
                "name" => "Europe/Zurich"
            ],
            [
                "id" => 343,
                "name" => "Indian/Antananarivo"
            ],
            [
                "id" => 344,
                "name" => "Indian/Chagos"
            ],
            [
                "id" => 345,
                "name" => "Indian/Christmas"
            ],
            [
                "id" => 346,
                "name" => "Indian/Cocos"
            ],
            [
                "id" => 347,
                "name" => "Indian/Comoro"
            ],
            [
                "id" => 348,
                "name" => "Indian/Kerguelen"
            ],
            [
                "id" => 349,
                "name" => "Indian/Mahe"
            ],
            [
                "id" => 350,
                "name" => "Indian/Maldives"
            ],
            [
                "id" => 351,
                "name" => "Indian/Mauritius"
            ],
            [
                "id" => 352,
                "name" => "Indian/Mayotte"
            ],
            [
                "id" => 353,
                "name" => "Indian/Reunion"
            ],
            [
                "id" => 354,
                "name" => "Pacific/Apia"
            ],
            [
                "id" => 355,
                "name" => "Pacific/Auckland"
            ],
            [
                "id" => 356,
                "name" => "Pacific/Bougainville"
            ],
            [
                "id" => 357,
                "name" => "Pacific/Chatham"
            ],
            [
                "id" => 358,
                "name" => "Pacific/Chuuk"
            ],
            [
                "id" => 359,
                "name" => "Pacific/Easter"
            ],
            [
                "id" => 360,
                "name" => "Pacific/Efate"
            ],
            [
                "id" => 361,
                "name" => "Pacific/Fakaofo"
            ],
            [
                "id" => 362,
                "name" => "Pacific/Fiji"
            ],
            [
                "id" => 363,
                "name" => "Pacific/Funafuti"
            ],
            [
                "id" => 364,
                "name" => "Pacific/Galapagos"
            ],
            [
                "id" => 365,
                "name" => "Pacific/Gambier"
            ],
            [
                "id" => 366,
                "name" => "Pacific/Guadalcanal"
            ],
            [
                "id" => 367,
                "name" => "Pacific/Guam"
            ],
            [
                "id" => 368,
                "name" => "Pacific/Honolulu"
            ],
            [
                "id" => 369,
                "name" => "Pacific/Kanton"
            ],
            [
                "id" => 370,
                "name" => "Pacific/Kiritimati"
            ],
            [
                "id" => 371,
                "name" => "Pacific/Kosrae"
            ],
            [
                "id" => 372,
                "name" => "Pacific/Kwajalein"
            ],
            [
                "id" => 373,
                "name" => "Pacific/Majuro"
            ],
            [
                "id" => 374,
                "name" => "Pacific/Marquesas"
            ],
            [
                "id" => 375,
                "name" => "Pacific/Midway"
            ],
            [
                "id" => 376,
                "name" => "Pacific/Nauru"
            ],
            [
                "id" => 377,
                "name" => "Pacific/Niue"
            ],
            [
                "id" => 378,
                "name" => "Pacific/Norfolk"
            ],
            [
                "id" => 379,
                "name" => "Pacific/Noumea"
            ],
            [
                "id" => 380,
                "name" => "Pacific/Pago_Pago"
            ],
            [
                "id" => 381,
                "name" => "Pacific/Palau"
            ],
            [
                "id" => 382,
                "name" => "Pacific/Pitcairn"
            ],
            [
                "id" => 383,
                "name" => "Pacific/Pohnpei"
            ],
            [
                "id" => 384,
                "name" => "Pacific/Port_Moresby"
            ],
            [
                "id" => 385,
                "name" => "Pacific/Rarotonga"
            ],
            [
                "id" => 386,
                "name" => "Pacific/Saipan"
            ],
            [
                "id" => 387,
                "name" => "Pacific/Tahiti"
            ],
            [
                "id" => 388,
                "name" => "Pacific/Tarawa"
            ],
            [
                "id" => 389,
                "name" => "Pacific/Tongatapu"
            ],
            [
                "id" => 390,
                "name" => "Pacific/Wake"
            ],
            [
                "id" => 391,
                "name" => "Pacific/Wallis"
            ],
            [
                "id" => 392,
                "name" => "Africa/Asmera"
            ],
            [
                "id" => 393,
                "name" => "Africa/Timbuktu"
            ],
            [
                "id" => 394,
                "name" => "America/Argentina/ComodRivadavia"
            ],
            [
                "id" => 395,
                "name" => "America/Atka"
            ],
            [
                "id" => 396,
                "name" => "America/Buenos_Aires"
            ],
            [
                "id" => 397,
                "name" => "America/Catamarca"
            ],
            [
                "id" => 398,
                "name" => "America/Coral_Harbour"
            ],
            [
                "id" => 399,
                "name" => "America/Cordoba"
            ],
            [
                "id" => 400,
                "name" => "America/Ensenada"
            ],
            [
                "id" => 401,
                "name" => "America/Fort_Wayne"
            ],
            [
                "id" => 402,
                "name" => "America/Godthab"
            ],
            [
                "id" => 403,
                "name" => "America/Indianapolis"
            ],
            [
                "id" => 404,
                "name" => "America/Jujuy"
            ],
            [
                "id" => 405,
                "name" => "America/Knox_IN"
            ],
            [
                "id" => 406,
                "name" => "America/Louisville"
            ],
            [
                "id" => 407,
                "name" => "America/Mendoza"
            ],
            [
                "id" => 408,
                "name" => "America/Montreal"
            ],
            [
                "id" => 409,
                "name" => "America/Nipigon"
            ],
            [
                "id" => 410,
                "name" => "America/Pangnirtung"
            ],
            [
                "id" => 411,
                "name" => "America/Porto_Acre"
            ],
            [
                "id" => 412,
                "name" => "America/Rainy_River"
            ],
            [
                "id" => 413,
                "name" => "America/Rosario"
            ],
            [
                "id" => 414,
                "name" => "America/Santa_Isabel"
            ],
            [
                "id" => 415,
                "name" => "America/Shiprock"
            ],
            [
                "id" => 416,
                "name" => "America/Thunder_Bay"
            ],
            [
                "id" => 417,
                "name" => "America/Virgin"
            ],
            [
                "id" => 418,
                "name" => "America/Yellowknife"
            ],
            [
                "id" => 419,
                "name" => "Antarctica/South_Pole"
            ],
            [
                "id" => 420,
                "name" => "Asia/Ashkhabad"
            ],
            [
                "id" => 421,
                "name" => "Asia/Calcutta"
            ],
            [
                "id" => 422,
                "name" => "Asia/Chongqing"
            ],
            [
                "id" => 423,
                "name" => "Asia/Chungking"
            ],
            [
                "id" => 424,
                "name" => "Asia/Dacca"
            ],
            [
                "id" => 425,
                "name" => "Asia/Harbin"
            ],
            [
                "id" => 426,
                "name" => "Asia/Istanbul"
            ],
            [
                "id" => 427,
                "name" => "Asia/Kashgar"
            ],
            [
                "id" => 428,
                "name" => "Asia/Katmandu"
            ],
            [
                "id" => 429,
                "name" => "Asia/Macao"
            ],
            [
                "id" => 430,
                "name" => "Asia/Rangoon"
            ],
            [
                "id" => 431,
                "name" => "Asia/Saigon"
            ],
            [
                "id" => 432,
                "name" => "Asia/Tel_Aviv"
            ],
            [
                "id" => 433,
                "name" => "Asia/Thimbu"
            ],
            [
                "id" => 434,
                "name" => "Asia/Ujung_Pandang"
            ],
            [
                "id" => 435,
                "name" => "Asia/Ulan_Bator"
            ],
            [
                "id" => 436,
                "name" => "Atlantic/Faeroe"
            ],
            [
                "id" => 437,
                "name" => "Atlantic/Jan_Mayen"
            ],
            [
                "id" => 438,
                "name" => "Australia/ACT"
            ],
            [
                "id" => 439,
                "name" => "Australia/Canberra"
            ],
            [
                "id" => 440,
                "name" => "Australia/Currie"
            ],
            [
                "id" => 441,
                "name" => "Australia/LHI"
            ],
            [
                "id" => 442,
                "name" => "Australia/North"
            ],
            [
                "id" => 443,
                "name" => "Australia/NSW"
            ],
            [
                "id" => 444,
                "name" => "Australia/Queensland"
            ],
            [
                "id" => 445,
                "name" => "Australia/South"
            ],
            [
                "id" => 446,
                "name" => "Australia/Tasmania"
            ],
            [
                "id" => 447,
                "name" => "Australia/Victoria"
            ],
            [
                "id" => 448,
                "name" => "Australia/West"
            ],
            [
                "id" => 449,
                "name" => "Australia/Yancowinna"
            ],
            [
                "id" => 450,
                "name" => "Brazil/Acre"
            ],
            [
                "id" => 451,
                "name" => "Brazil/DeNoronha"
            ],
            [
                "id" => 452,
                "name" => "Brazil/East"
            ],
            [
                "id" => 453,
                "name" => "Brazil/West"
            ],
            [
                "id" => 454,
                "name" => "Canada/Atlantic"
            ],
            [
                "id" => 455,
                "name" => "Canada/Central"
            ],
            [
                "id" => 456,
                "name" => "Canada/Eastern"
            ],
            [
                "id" => 457,
                "name" => "Canada/Mountain"
            ],
            [
                "id" => 458,
                "name" => "Canada/Newfoundland"
            ],
            [
                "id" => 459,
                "name" => "Canada/Pacific"
            ],
            [
                "id" => 460,
                "name" => "Canada/Saskatchewan"
            ],
            [
                "id" => 461,
                "name" => "Canada/Yukon"
            ],
            [
                "id" => 462,
                "name" => "CET"
            ],
            [
                "id" => 463,
                "name" => "Chile/Continental"
            ],
            [
                "id" => 464,
                "name" => "Chile/EasterIsland"
            ],
            [
                "id" => 465,
                "name" => "CST6CDT"
            ],
            [
                "id" => 466,
                "name" => "Cuba"
            ],
            [
                "id" => 467,
                "name" => "EET"
            ],
            [
                "id" => 468,
                "name" => "Egypt"
            ],
            [
                "id" => 469,
                "name" => "Eire"
            ],
            [
                "id" => 470,
                "name" => "EST"
            ],
            [
                "id" => 471,
                "name" => "EST5EDT"
            ],
            [
                "id" => 472,
                "name" => "Etc/GMT"
            ],
            [
                "id" => 473,
                "name" => "Etc/GMT+0"
            ],
            [
                "id" => 474,
                "name" => "Etc/GMT+1"
            ],
            [
                "id" => 475,
                "name" => "Etc/GMT+10"
            ],
            [
                "id" => 476,
                "name" => "Etc/GMT+11"
            ],
            [
                "id" => 477,
                "name" => "Etc/GMT+12"
            ],
            [
                "id" => 478,
                "name" => "Etc/GMT+2"
            ],
            [
                "id" => 479,
                "name" => "Etc/GMT+3"
            ],
            [
                "id" => 480,
                "name" => "Etc/GMT+4"
            ],
            [
                "id" => 481,
                "name" => "Etc/GMT+5"
            ],
            [
                "id" => 482,
                "name" => "Etc/GMT+6"
            ],
            [
                "id" => 483,
                "name" => "Etc/GMT+7"
            ],
            [
                "id" => 484,
                "name" => "Etc/GMT+8"
            ],
            [
                "id" => 485,
                "name" => "Etc/GMT+9"
            ],
            [
                "id" => 486,
                "name" => "Etc/GMT-0"
            ],
            [
                "id" => 487,
                "name" => "Etc/GMT-1"
            ],
            [
                "id" => 488,
                "name" => "Etc/GMT-10"
            ],
            [
                "id" => 489,
                "name" => "Etc/GMT-11"
            ],
            [
                "id" => 490,
                "name" => "Etc/GMT-12"
            ],
            [
                "id" => 491,
                "name" => "Etc/GMT-13"
            ],
            [
                "id" => 492,
                "name" => "Etc/GMT-14"
            ],
            [
                "id" => 493,
                "name" => "Etc/GMT-2"
            ],
            [
                "id" => 494,
                "name" => "Etc/GMT-3"
            ],
            [
                "id" => 495,
                "name" => "Etc/GMT-4"
            ],
            [
                "id" => 496,
                "name" => "Etc/GMT-5"
            ],
            [
                "id" => 497,
                "name" => "Etc/GMT-6"
            ],
            [
                "id" => 498,
                "name" => "Etc/GMT-7"
            ],
            [
                "id" => 499,
                "name" => "Etc/GMT-8"
            ],
            [
                "id" => 500,
                "name" => "Etc/GMT-9"
            ],
            [
                "id" => 501,
                "name" => "Etc/GMT0"
            ],
            [
                "id" => 502,
                "name" => "Etc/Greenwich"
            ],
            [
                "id" => 503,
                "name" => "Etc/UCT"
            ],
            [
                "id" => 504,
                "name" => "Etc/Universal"
            ],
            [
                "id" => 505,
                "name" => "Etc/UTC"
            ],
            [
                "id" => 506,
                "name" => "Etc/Zulu"
            ],
            [
                "id" => 507,
                "name" => "Europe/Belfast"
            ],
            [
                "id" => 508,
                "name" => "Europe/Kiev"
            ],
            [
                "id" => 509,
                "name" => "Europe/Nicosia"
            ],
            [
                "id" => 510,
                "name" => "Europe/Tiraspol"
            ],
            [
                "id" => 511,
                "name" => "Europe/Uzhgorod"
            ],
            [
                "id" => 512,
                "name" => "Europe/Zaporozhye"
            ],
            [
                "id" => 513,
                "name" => "Factory"
            ],
            [
                "id" => 514,
                "name" => "GB"
            ],
            [
                "id" => 515,
                "name" => "GB-Eire"
            ],
            [
                "id" => 516,
                "name" => "GMT"
            ],
            [
                "id" => 517,
                "name" => "GMT+0"
            ],
            [
                "id" => 518,
                "name" => "GMT-0"
            ],
            [
                "id" => 519,
                "name" => "GMT0"
            ],
            [
                "id" => 520,
                "name" => "Greenwich"
            ],
            [
                "id" => 521,
                "name" => "Hongkong"
            ],
            [
                "id" => 522,
                "name" => "HST"
            ],
            [
                "id" => 523,
                "name" => "Iceland"
            ],
            [
                "id" => 524,
                "name" => "Iran"
            ],
            [
                "id" => 525,
                "name" => "Israel"
            ],
            [
                "id" => 526,
                "name" => "Jamaica"
            ],
            [
                "id" => 527,
                "name" => "Japan"
            ],
            [
                "id" => 528,
                "name" => "Kwajalein"
            ],
            [
                "id" => 529,
                "name" => "Libya"
            ],
            [
                "id" => 530,
                "name" => "MET"
            ],
            [
                "id" => 531,
                "name" => "Mexico/BajaNorte"
            ],
            [
                "id" => 532,
                "name" => "Mexico/BajaSur"
            ],
            [
                "id" => 533,
                "name" => "Mexico/General"
            ],
            [
                "id" => 534,
                "name" => "MST"
            ],
            [
                "id" => 535,
                "name" => "MST7MDT"
            ],
            [
                "id" => 536,
                "name" => "Navajo"
            ],
            [
                "id" => 537,
                "name" => "NZ"
            ],
            [
                "id" => 538,
                "name" => "NZ-CHAT"
            ],
            [
                "id" => 539,
                "name" => "Pacific/Enderbury"
            ],
            [
                "id" => 540,
                "name" => "Pacific/Johnston"
            ],
            [
                "id" => 541,
                "name" => "Pacific/Ponape"
            ],
            [
                "id" => 542,
                "name" => "Pacific/Samoa"
            ],
            [
                "id" => 543,
                "name" => "Pacific/Truk"
            ],
            [
                "id" => 544,
                "name" => "Pacific/Yap"
            ],
            [
                "id" => 545,
                "name" => "Poland"
            ],
            [
                "id" => 546,
                "name" => "Portugal"
            ],
            [
                "id" => 547,
                "name" => "PRC"
            ],
            [
                "id" => 548,
                "name" => "PST8PDT"
            ],
            [
                "id" => 549,
                "name" => "ROC"
            ],
            [
                "id" => 550,
                "name" => "ROK"
            ],
            [
                "id" => 551,
                "name" => "Singapore"
            ],
            [
                "id" => 552,
                "name" => "Turkey"
            ],
            [
                "id" => 553,
                "name" => "UCT"
            ],
            [
                "id" => 554,
                "name" => "Universal"
            ],
            [
                "id" => 555,
                "name" => "US/Alaska"
            ],
            [
                "id" => 556,
                "name" => "US/Aleutian"
            ],
            [
                "id" => 557,
                "name" => "US/Arizona"
            ],
            [
                "id" => 558,
                "name" => "US/Central"
            ],
            [
                "id" => 559,
                "name" => "US/East-Indiana"
            ],
            [
                "id" => 560,
                "name" => "US/Eastern"
            ],
            [
                "id" => 561,
                "name" => "US/Hawaii"
            ],
            [
                "id" => 562,
                "name" => "US/Indiana-Starke"
            ],
            [
                "id" => 563,
                "name" => "US/Michigan"
            ],
            [
                "id" => 564,
                "name" => "W-SU"
            ],
            [
                "id" => 565,
                "name" => "WET"
            ],
            [
                "id" => 566,
                "name" => "Zulu"
            ]

        ];
        DB::table('time_zones')->insert($timeZones);
    }
}
