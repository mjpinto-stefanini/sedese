<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AmbitoAtuacao;
use App\Models\Deficiencia;
use App\Models\Escolaridade;
use App\Models\Profissao;
use App\Models\AcoesTematica;
use App\Models\AcoesAreaEnvolvida;
use App\Models\AcoesTipologia;
use App\Models\TipoPerfil;
use App\Models\UserPerfilStatus;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
                'id' => '485cad85-b3ee-48d2-b791-6aac05f878cf',
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('1q2w3e4r'),
                'is_admin' => true,
                'is_superuser' => true,
                'is_active' => true,
                'type_admin' => User::USER_ADMINISTRADOR,
                'cpf' => '123.456.789-03',
                'birthday' => '1990-01-01'
            ],
            [
                'id' => '545879d0-6ecd-4343-9f47-304f42a5cd12',
                'name' => 'Andre Abreu',
                'email' => 'aabreu@stefanini.com',
                'password' => bcrypt('1q2w3e4r'),
                'is_admin' => true,
                'is_superuser' => false,
                'is_active' => true,
                'type_admin' => User::USER_ADMINISTRADOR,
                'cpf' => '123.456.789-03',
                'birthday' => '1990-01-01'
            ],
            [
                'id' => '67f85f5f-6142-4c71-98d6-eb21f2f69c81',
                'name' => 'User',
                'email' => 'user@user.com',
                'password' => bcrypt('12345678'),
                'is_admin' => false,
                'is_superuser' => false,
                'is_active' => true,
                'type_admin' => User::USER_USUARIO,
                'cpf' => '123.456.789-03',
                'birthday' => '1990-01-01'
            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }
        // cadastrando dentro da seed o tipo de perfil
        TipoPerfil::create(['id' => 1,'nome' => 'Responsável técnico']);
        TipoPerfil::create(['id' => 2,'nome' => 'Participante']);
        $usersTiposPerfils = [
            [
                'user_id' => '485cad85-b3ee-48d2-b791-6aac05f878cf',
                'tipo_perfil_id' => '1',
                'status' => 1,
            ],[
                'user_id' => '545879d0-6ecd-4343-9f47-304f42a5cd12',
                'tipo_perfil_id' => '1',
                'status' => 1,
            ],[
                'user_id' => '67f85f5f-6142-4c71-98d6-eb21f2f69c81',
                'tipo_perfil_id' => '2',
                'status' => 1,
            ]
        ];
        foreach ($usersTiposPerfils as $tipoUs):
            UserPerfilStatus::create($tipoUs);
        endforeach;

        $ambitos = [
            [
                'nome' => 'Abadia dos Dourados',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Abaeté',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Abre Campo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Acaiaca',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Açucena',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Água Boa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Água Comprida',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Aguanil',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Águas Formosas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Águas Vermelhas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Aimorés',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Aiuruoca',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alagoa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Albertina',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Além Paraíba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alfenas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alfredo Vasconcelos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Almenara',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alpercata',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alpinópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alterosa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alto Caparaó',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alto Jequitibá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alto Rio Doce',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alvarenga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alvinópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alvorada de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Amparo do Serra',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Andradas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cachoeira de Pajeú',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Andrelândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Angelândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Antônio Carlos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Antônio Dias',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Antônio Prado de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Araçaí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Aracitaba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Araçuaí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Araguari',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Arantina',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Araponga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Araporã',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Arapuá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Araújos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Araxá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Arceburgo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Arcos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Areado',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Argirita',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Aricanduva',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Arinos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Astolfo Dutra',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ataléia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Augusto de Lima',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Baependi',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Baldim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bambuí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bandeira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bandeira do Sul',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Barão de Cocais',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Barão de Monte Alto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Barbacena',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Barra Longa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Barroso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bela Vista de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Belmiro Braga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Belo Horizonte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Belo Oriente',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Belo Vale',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Berilo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Berizal',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bertópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Betim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bias Fortes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bicas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Biquinhas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Boa Esperança',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bocaina de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bocaiúva',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bom Despacho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bom Jardim de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bom Jesus da Penha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bom Jesus do Amparo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bom Jesus do Galho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bom Repouso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bom Sucesso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bonfim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bonfinópolis de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bonito de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Borda da Mata',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Botelhos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Botumirim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Brás Pires',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Brasilândia de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Brasília de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Brasópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Braúnas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Brumadinho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bueno Brandão',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Buenópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Bugre',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Buritis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Buritizeiro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cabeceira Grande',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cabo Verde',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cachoeira da Prata',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cachoeira de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cachoeira de Pajeú',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cachoeira Dourada',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caetanópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caeté',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caiana',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cajuri',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caldas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Camacho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Camanducaia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cambuí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cambuquira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campanário',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campanha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campestre',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campina Verde',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campo Azul',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campo Belo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campo do Meio',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campo Florido',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campos Altos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Campos Gerais',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cana Verde',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Canaã',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Canápolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Candeias',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cantagalo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caparaó',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Capela Nova',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Capelinha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Capetinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Capim Branco',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Capinópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Capitão Andrade',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Capitão Enéas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Capitólio',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caputira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caraí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caranaíba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carandaí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carangola',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caratinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carbonita',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Careaçu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carlos Chagas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carmésia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carmo da Cachoeira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carmo da Mata',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carmo de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carmo do Cajuru',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carmo do Paranaíba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carmo do Rio Claro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carmópolis de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carneirinho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carrancas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carvalhópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Carvalhos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Casa Grande',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cascalho Rico',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cássia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conceição da Barra de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cataguases',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Catas Altas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Catas Altas da Noruega',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Catuji',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Catuti',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Caxambu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cedro do Abaeté',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Central de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Centralina',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Chácara',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Chalé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Chapada do Norte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Chapada Gaúcha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Chiador',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cipotânea',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Claraval',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Claro dos Poções',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cláudio',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coimbra',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coluna',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Comendador Gomes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Comercinho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conceição da Aparecida',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conceição das Pedras',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conceição das Alagoas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conceição de Ipanema',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conceição do Mato Dentro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conceição do Pará',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conceição do Rio Verde',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conceição dos Ouros',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cônego Marinho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Confins',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Congonhal',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Congonhas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Congonhas do Norte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conquista',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conselheiro Lafaiete',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Conselheiro Pena',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Consolação',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Contagem',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coqueiral',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coração de Jesus',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cordisburgo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cordislândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Corinto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coroaci',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coromandel',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coronel Fabriciano',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coronel Murta',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coronel Pacheco',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Coronel Xavier Chaves',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Córrego Danta',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Córrego do Bom Jesus',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Córrego Fundo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Córrego Novo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Couto de Magalhães de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Crisólita',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cristais',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cristália',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cristiano Otoni',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cristina',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Crucilândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cruzeiro da Fortaleza',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cruzília',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Cuparaque',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Curral de Dentro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Curvelo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Datas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Delfim Moreira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Delfinópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Delta',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Descoberto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Desterro de Entre Rios',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Desterro do Melo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Diamantina',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Diogo de Vasconcelos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dionísio',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Divinésia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Divino',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Divino das Laranjeiras',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Divinolândia de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Divinópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Divisa Alegre',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Divisa Nova',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Divisópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dom Bosco',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dom Cavati',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dom Joaquim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dom Silvério',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dom Viçoso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dona Eusébia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dores de Campos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dores de Guanhães',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dores do Indaiá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Dores do Turvo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Doresópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Douradoquara',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Durandé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Elói Mendes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Engenheiro Caldas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Engenheiro Navarro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Entre Folhas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Entre Rios de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ervália',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Esmeraldas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Espera Feliz',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Espinosa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Espírito Santo do Dourado',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Estiva',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Estrela Dalva',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Estrela do Indaiá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Estrela do Sul',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Eugenópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ewbank da Câmara',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Extrema',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Fama',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Faria Lemos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Felício dos Santos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Felisburgo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Felixlândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Fernandes Tourinho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ferros',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Fervedouro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Florestal',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Formiga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Formoso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Fortaleza de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Fortuna de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Francisco Badaró',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Francisco Dumont',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Francisco Sá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Franciscópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Frei Gaspar',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Frei Inocêncio',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Frei Lagonegro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Fronteira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Fronteira dos Vales',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Fruta de Leite',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Frutal',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Funilândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Galiléia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Gameleiras',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Glaucilândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Goiabeira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Goianá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Gonçalves',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Gonzaga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Gouveia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Governador Valadares',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Grão Mogol',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Grupiara',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guanhães',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guapé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guaraciaba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guaraciama',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guaranésia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guarani',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guarará',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guarda-Mor',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guaxupé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guidoval',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guimarânia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Guiricema',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Gurinhatã',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Heliodora',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Iapu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ibertioga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ibiá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ibiaí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ibiracatu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ibiraci',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ibirité',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ibitiúra de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ibituruna',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Icaraí de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Igarapé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Igaratinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Iguatama',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ijaci',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ilicínea',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Imbé de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Inconfidentes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Indaiabira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Indianópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ingaí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Inhapim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Inhaúma',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Inimutaba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ipaba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ipanema',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ipatinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ipiaçu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ipuiúna',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Iraí de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itabira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itabirinha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itabirito',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itacambira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itacarambi',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itaguara',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itaipé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itajubá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itamarandiba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itamarati de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itambacuri',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itambé do Mato Dentro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itamogi',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itamonte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itanhandu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itanhomi',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itaobim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itapagipe',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itapecerica',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itapeva',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itatiaiuçu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itaú de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itaúna',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itaverava',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itueta',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ituiutaba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itumirim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Iturama',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Itutinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jaboticatubas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jacinto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jacuí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jacutinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jaguaraçu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jaíba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jampruca',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Janaúba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Januária',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Japaraíba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Japonvar',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jeceaba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jenipapo de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jequeri',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jequitaí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jequitibá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jequitinhonha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jesuânia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Joaíma',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Joanésia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'João Monlevade',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'João Pinheiro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Joaquim Felício',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Jordânia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'José Gonçalves de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'José Raydan',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Josenópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova União',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Juatuba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Juiz de Fora',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Juramento',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Juruaia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Juvenília',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ladainha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lagamar',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lagoa da Prata',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lagoa dos Patos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lagoa Dourada',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lagoa Formosa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lagoa Grande',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lagoa Santa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lajinha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lambari',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lamim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Laranjal',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lassance',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lavras',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Leandro Ferreira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Leme do Prado',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Leopoldina',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Liberdade',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lima Duarte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Limeira do Oeste',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Lontra',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Luisburgo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Luislândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Luminárias',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Luz',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Machacalis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Machado',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Madre de Deus de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Malacacheta',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mamonas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Manga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Manhuaçu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Manhumirim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mantena',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mar de Espanha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Maravilhas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Maria da Fé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mariana',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Marilac',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mário Campos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Maripá de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Marliéria',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Marmelópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Martinho Campos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Martins Soares',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mata Verde',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Materlândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mateus Leme',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mathias Lobato',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Matias Barbosa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Matias Cardoso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Matipó',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mato Verde',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Matozinhos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Matutina',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Medeiros',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Medina',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mendes Pimentel',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mercês',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mesquita',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Minas Novas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Minduri',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mirabela',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Miradouro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Miraí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Miravânia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Moeda',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Moema',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Monjolos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Monsenhor Paulo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Montalvânia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Monte Alegre de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Monte Azul',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Monte Belo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Monte Carmelo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Monte Formoso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Monte Santo de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Monte Sião',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Montes Claros',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Montezuma',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Morada Nova de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Morro da Garça',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Morro do Pilar',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Munhoz',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Muriaé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Mutum',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Muzambinho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nacip Raydan',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nanuque',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Naque',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Natalândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Natércia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nazareno',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nepomuceno',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ninheira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova Belém',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova Era',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova Lima',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova Módica',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova Ponte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova Porteirinha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova Resende',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova Serrana',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Nova União',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Novo Cruzeiro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Novo Oriente de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Novorizonte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Olaria',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => "Olhos-d'Água",
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Olímpio Noronha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Oliveira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Oliveira Fortes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Onça de Pitangui',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Oratórios',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Orizânia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ouro Branco',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ouro Fino',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ouro Preto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ouro Verde de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Padre Carvalho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Padre Paraíso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pai Pedro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Paineiras',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pains',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Paiva',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Palma',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Palmópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Papagaios',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pará de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Paracatu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Paraguaçu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Paraisópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Paraopeba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Passa Quatro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Passa Tempo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Passa-Vinte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Passabém',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Passos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Patis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Patos de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Patrocínio',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Patrocínio do Muriaé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Paula Cândido',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Paulistas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pavão',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Peçanha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedra Azul',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedra Bonita',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedra do Anta',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedra do Indaiá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedra Dourada',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedralva',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedras de Maria da Cruz',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedrinópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedro Leopoldo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pedro Teixeira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pequeri',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pequi',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Perdigão',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Perdizes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Perdões',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Periquito',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pescador',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piau',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piedade de Caratinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piedade de Ponte Nova',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piedade do Rio Grande',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piedade dos Gerais',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pimenta',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pingo-D\'Água',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pintópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piracema',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pirajuba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piranga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piranguçu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piranguinho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pirapetinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pirapora',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piraúba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pitangui',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Piumhi',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Planura',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Poço Fundo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Poços de Caldas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pocrane',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pompéu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ponte Nova',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ponto Chique',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ponto dos Volantes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Porteirinha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Porto Firme',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Poté',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pouso Alegre',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pouso Alto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Prados',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Prata',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pratápolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Pratinha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Presidente Bernardes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Presidente Juscelino',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Presidente Kubitschek',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Presidente Olegário',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Alto Jequitibá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Prudente de Morais',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Quartel Geral',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Queluzito',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Raposos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Raul Soares',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Recreio',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Reduto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Resende Costa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Resplendor',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ressaquinha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Riachinho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Riacho dos Machados',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ribeirão das Neves',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ribeirão Vermelho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Acima',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Casca',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Doce',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio do Prado',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Espera',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Manso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Novo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Paranaíba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Pardo de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Piracicaba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Pomba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Preto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rio Vermelho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ritápolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rochedo de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rodeiro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Romaria',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rosário da Limeira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rubelita',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Rubim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sabará',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sabinópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sacramento',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Salinas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Salto da Divisa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Bárbara',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Bárbara do Leste',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Bárbara do Monte Verde',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Bárbara do Tugúrio',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Cruz de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Cruz de Salinas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Cruz do Escalvado',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Efigênia de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Fé de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Helena de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Juliana',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Luzia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Margarida',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Maria de Itabira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Maria do Salto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Maria do Suaçuí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Rita de Caldas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Rita de Ibitipoca',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Rita de Jacutinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Rita de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Rita do Itueto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Rita do Sapucaí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Rosa da Serra',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santa Vitória',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana da Vargem',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana de Cataguases',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana de Pirapama',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana do Deserto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana do Garambéu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana do Jacaré',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana do Manhuaçu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana do Paraíso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana do Riacho',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santana dos Montes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santo Antônio do Amparo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santo Antônio do Aventureiro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santo Antônio do Grama',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santo Antônio do Itambé',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santo Antônio do Jacinto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santo Antônio do Monte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santo Antônio do Retiro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santo Antônio do Rio Abaixo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santo Hipólito',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Santos Dumont',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Bento Abade',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Brás do Suaçuí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Domingos das Dores',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Domingos do Prata',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Félix de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Francisco',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Francisco de Paula',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Francisco de Sales',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Francisco do Glória',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Geraldo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Geraldo da Piedade',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Geraldo do Baixio',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Gonçalo do Abaeté',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Gonçalo do Pará',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Gonçalo do Rio Abaixo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Gonçalo do Rio Preto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Gonçalo do Sapucai',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Gotardo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João Batista do Glória',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João da Lagoa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João da Mata',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João da Ponte',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João das Missões',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João del Rei',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João do Manhuaçu',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João do Manteninha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João do Oriente',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João do Pacuí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João do Paraíso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João Evangelista',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São João Nepomuceno',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Joaquim de Bicas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São José da Barra',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São José da Lapa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São José da Safira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São José da Varginha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São José do Alegre',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São José do Divino',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São José do Goiabal',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São José do Jacuri',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São José do Mantimento',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Lourenço',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Miguel do Anta',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Pedro da União',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Pedro do Suaçuí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Pedro dos Ferros',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Romão',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Roque de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Sebastião da Bela Vista',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Sebastião da Vargem Alegre',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Sebastião do Anta',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Sebastião do Maranhão',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Sebastião do Oeste',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Sebastião do Paraíso',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Sebastião do Rio Preto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Sebastião do Rio Verde',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Thomé das Letras',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Tiago',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Tomás de Aquino',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'São Vicente de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sapucaí-Mirim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sardoá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sarzedo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sem-Peixe',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Senador Amaral',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Senador Cortes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Senador Firmino',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Senador José Bento',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Senador Modestino Gonçalves',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Senhora de Oliveira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Senhora do Porto',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Senhora dos Remédios',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sericita',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Seritinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Serra Azul de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Serra da Saudade',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Serra do Salitre',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Serra dos Aimorés',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Serrania',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Serranópolis de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Serranos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Serro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sete Lagoas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Setubinha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Silveirânia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Silvianópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Simão Pereira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Simonésia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Sobrália',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Soledade de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tabuleiro',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Taiobeiras',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Taparuba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tapira',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tapiraí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Taquaraçu de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tarumirim',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Teixeiras',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Teófilo Otoni',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Timóteo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tiradentes',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tiros',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tocantins',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tocos do Moji',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Toledo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tombos',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Três Corações',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Três Marias',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Três Pontas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tumiritinga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Tupaciguara',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Turmalina',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Turvolândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ubá',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ubaí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Ubaporanga',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Uberaba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Uberlândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Umburatiba',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Unaí',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'União de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Uruana de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Urucânia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Urucuia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Vargem Alegre',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Vargem Bonita',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Vargem Grande do Rio Pardo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Varginha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Varjão de Minas',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Várzea da Palma',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Varzelândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Vazante',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Verdelândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Veredinha',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Veríssimo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Vermelho Novo',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Vespasiano',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Viçosa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Vieiras',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Virgem da Lapa',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Virgínia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Virginópolis',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Virgolândia',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Visconde do Rio Branco',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Volta Grande',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Wenceslau Braz',
                'regiao_administrativa' => 2,
            ],
            [
                'nome' => 'Diretoria Regional de Desenvolvimento Social',
                'regiao_administrativa' => 1,
            ],
            [
                'nome' => 'Subsecretaria de Assistência Social',
                'regiao_administrativa' => 1,
            ],
            [
                'nome' => 'Ceas',
                'regiao_administrativa' => 1,
            ],
            [
                'nome' => 'CREAS Regional',
                'regiao_administrativa' => 1,
            ],
            [
                'nome' => 'Outros Públicos',
                'regiao_administrativa' => 1,
            ],
        ];
        foreach ($ambitos as $ambito) {
            AmbitoAtuacao::create($ambito);
        }

        $deficiencias = [
            'Física',
            'Auditiva',
            'Visual',
            'Intelectual',
            'Múltipla',
            'Transtorno do Espectro',
            'Mental',
            'Autista',
            'Outras',
        ];
        foreach ($deficiencias as $deficiencia) {
            Deficiencia::create([
                'nome' => $deficiencia,
            ]);
        }

        $escolaridades = [
            [
                'nome' => 'Ensino Fundamental Completo',
            ],
            [
                'nome' => 'Ensino Fundamental Incompleto',
            ],
            [
                'nome' => 'Ensino Médio Completo',
            ],
            [
                'nome' => 'Ensino Médio Incompleto',
            ],
            [
                'nome' => 'Superior Completo',
            ],
            [
                'nome' => 'Superior Incompleto',
            ],
            [
                'nome' => 'Pós-Graduação Lato-Sensu Completa',
            ],
            [
                'nome' => 'Pós-Graduação Lato-Sensu Incompleta',
            ],
            [
                'nome' => 'Mestrado Completo',
            ],
            [
                'nome' => 'Mestrado Incompleto',
            ],
            [
                'nome' => 'Doutorado Completo',
            ],
            [
                'nome' => 'Doutorado Incompleto',
            ],
            [
                'nome' => 'Curso Técnico',
            ],
        ];
        foreach ($escolaridades as $escolaridade) {
            Escolaridade::create($escolaridade);
        }

        $profissoes = [
            'Assistente Social',
            'Psicólogo',
            'Advogado',
            'Administrador',
            'Antropólogo',
            'Economista',
            'Economista Doméstico',
            'Pedagogo',
            'Sociólogo',
            'Terapeuta',
            'Terapeuta Ocupacional',
            'Musicoterapeuta',
            'Contador',
            'Estudante',
            'Sem formação Profissional',
        ];
        foreach ($profissoes as $profissao) {
            Profissao::create([
                'nome' => $profissao,
            ]);
        }

        $acoesTematicas = [
            'Atuação no contexto de COVID-19',
            'Benefício de Prestação Continuada (BPC)',
            'Benefícios Eventuais',
            'Bolsa Merenda',
            'Cadastro Único e Programa Bolsa Família',
            'Calamidade Pública ou Emergências',
            'Controle Social',
            'Diagnóstico Socioterritorial, Indicadores, Monitoramento e Avaliação do SUAS',
            'Distribuição de Cestas Básicas pela SEDESE',
            'Entidades Socioassistenciais',
            'Gestão do SUAS',
            'Gestão Financeira e Orçamentária (Recursos de cofinanciamento federal, utilização, prestação de contas, etc)',
            'IGD PBF',
            'IGD SUAS',
            'Orientações Gerais sobre a Proteção Social Básica',
            'Orientações Gerais sobre a Proteção Social Especial',
            'Orientações Gerais sobre a Proteção Social Especial de Alta Complexidade',
            'Orientações Gerais sobre a Proteção Social Especial de Média Complexidade',
            'Outros',
            'PAEFI - Serviço de Proteção e Atendimento Especializado a Famílias e Indivíduos',
            'Piso Mineiro (Utilização, Plano de Serviços, Demonstrativo, etc)',
            'Preenchimento de Sistemas de Informação do SUAS',
            'Programa Acessuas Trabalho',
            'Programa BPC na Escola',
            'Programa Percursos Gerais - Aproximação SUAS',
            'PSAC - Adultos e Famílias',
            'PSAC - Crianças e Adolescentes',
            'PSAC - Idosos',
            'PSAC - Mulher em Situação de Violência',
            'PSAC - Pessoas com Deficiência',
            'PSB - PAIF - Serviço de Proteção e Atendimento Integral a Famílias',
            'PSB - SCFV - Serviço de Convivência e Fortalecimento de Vínculos e SISC*',
            'PSB - Serviço de Proteção Social Básica no Domicílio para Pessoas com Deficiencia e Idosas',
            'PSEMC - Certidões da FEBEM',
            'PSEMC - Medidas Socioeducativas em Meio Aberto',
            'PSEMC - População em Situação de Rua',
            'PSEMC - Povos e Comunidades Tradicionais',
            'PSEMC - Programa de Erradicação do Trabalho Infantil (PETI)',
            'PSEMC - Violência contra a Pessoa com Deficiência',
            'PSEMC - Violência contra Crianças e Adolescentes (Gerais)',
            'PSEMC - Violência contra Idoso',
            'PSEMC - Violência contra Mulher',
            'PSEMC - Violência Sexual contra Crianças e Adolescentes',
            'Recursos Emergencial para Enfrentamento ao COVID19',
            'Rede Cuidar',
            'Renda Minas',
            'Serviço de Acolhimento em Republica',
            'Serviços Socioassistenciais no Período Eleitoral',
            'Sistemas de Gerenciamento do CadÚnico e PBF (V.7, SIBEC, SICON, SIGPBF, CECAD, etc)',
            'SUAS e o Sistema de Justiça',
            'Trabalho Escravo',
            'Tráfico Humano',
            'Vigilância Socioassistencial',
            'Orientações Gerais sobre a Educação Permanente no SUAS',
            'Auxílio Emergencial Mineiro',
            'MROSC',
            'Vigilância Socioassistencial',
            'Trabalho Social com Famílias e Benefícios Socioassistenciais',
            'Auxílio Brasil'
        ];

        foreach ($acoesTematicas as $acaoTematica) {
            AcoesTematica::create([
                'nome' => $acaoTematica,
            ]);
        }

        $acoesTipologia = [
            'Atendimento técnico',
            'Oficinas de apoio técnico',
            'Videoconferências',
            'Visitas de apoio técnico',
            'Eventos Técnicos',
            'Produção e disponibilização de materiais, cartilhas, cadernos e divulgação de orientações em Blogs, Sítios, entre outros',
            'Treinamentos EAD',
        ];

        foreach ($acoesTipologia as $acaoTipologia) {
            AcoesTipologia::create([
                'nome' => $acaoTipologia,
            ]);
        }

        $acoesAreaEnvolvidas = [
            'Subsecretaria de Assistência Social',
            'Superintendência de Proteção Social Básica',
            'Diretoria de Serviços e Benefícios Socioassistenciais',
            'Diretoria de Gestão do Cadastro Único e Programas Socioassistenciais',
            'Superintendência de Proteção Social Especial',
            'Diretoria de Proteção Social Especial de Média Complexidade',
            'Diretoria de Proteção Social Especial de Alta Complexidade',
            'Superintendência de Vigilância e Capacitação',
            'Diretoria de Vigilância Socioassistencial',
            'Diretoria de Educação Permanente do SUAS',
            'Diretoria de Gestão Descentralizada e Regulação do SUAS',
            'Assessoria de gestão do Fundo Estadual de Assistência Social',
            'Diretoria Regional de Almenara',
            'Diretoria Regional de Araçuaí',
            'Diretoria Regional de Curvelo',
            'Diretoria Regional de Diamantina',
            'Diretoria Regional de Divinópolis',
            'Diretoria Regional de Governador Valadares',
            'Diretoria Regional de Ituiutaba',
            'Diretoria Regional de Juiz de Fora',
            'Diretoria Regional de Metropolitana (BH)',
            'Diretoria Regional de Montes Claros',
            'Diretoria Regional de Muriaé',
            'Diretoria Regional de Paracatu',
            'Diretoria Regional de Passos',
            'Diretoria Regional de Patos de Minas',
            'Diretoria Regional de Poços de Caldas',
            'Diretoria Regional de Salinas',
            'Diretoria Regional de São João Del Rei',
            'Diretoria Regional de Teófilo Otoni',
            'Diretoria Regional de Timóteo',
            'Diretoria Regional de Uberaba',
            'Diretoria Regional de Uberlândia',
            'Diretoria Regional de Varginha',
        ];

        foreach ($acoesAreaEnvolvidas as $acoesAreaEnvolvida) {
            AcoesAreaEnvolvida::create([
                'nome' => $acoesAreaEnvolvida,
            ]);
        }

    }
}
