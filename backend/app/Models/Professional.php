<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{

    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'user_id',
        'regional',
        'superintendencia',
        'lotacao',
        'protecao_social_basica',
        'protecao_social_especial',
        'vigilancia_capacitacao',
        'vinculo_empregaticio',
        'funcao',
        'diretoria_regional_des_social',
        'creas_regional',
        'exe_creas_funcao',
        'exe_creas_vinc_empreg',
        'outros_publicos',
        'outros_publicos_others',
        'parceiros',
        'orgao',
        'area_de_atuacao',
        'protecao_social_basica_municipal',
        'beneficios_socioassistenciais',
        'protecao_social_especial_municipal',
        'social_especial_municipal_media_complexidade',
        'social_especial_municipal_alta_complexidade',
        'representacao',
        'area_representada',
        'area_representada_outros',
        'cargo',
        'representante',
        'representacao_titularidade',
        'representacao_segmento',
        'representacao_representacao',
        'representacao_conselho',
        'representacao_area_representada_outros',
        'representacao_area_representada',
        'funcao_outro',
        'vinculo_empregaticio_outro',
        'municipio_id',
        'servicos_programa_outro',
        'servicos_programa',
        'beneficios_municipal_outro',
        'beneficios_municipal',
        'created_at',
        'updated_at',
    ];
}
