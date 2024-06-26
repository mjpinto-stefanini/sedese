<template>
  <div class="col-sm-12 q-pt-sm">
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">
          <q-icon name="sym_o_work" color="primary"/> Profissionais
          <q-btn class="bg-primary text-caption text-white" @click="modalDadosProfissionaisFn()"
            style="float: right;">
            <font-awesome-icon :icon="['far', 'pen-to-square']" />
            <q-tooltip class="bg-primary text-caption outline" :offset="[10, 10]" style="max-width: 600px">
              Editar informações de profissionais.
            </q-tooltip>
          </q-btn>
        </div>
      </q-card-section>
      <q-card-section>
        <!--Estadual-->
        <div class="col-12 row q-col-gutter-y-md" v-if="professionalData.regional === 'Estadual' || professionalData.regional === '1'">
          <div class="col-12">
            <span class="text-grey">Âmbito de atuação:</span> Estadual
          </div>
          <div class="col-12">
            <span class="text-grey">Lotação:</span> {{ professionalData.lotacao }}
          </div>
          <div class="col-12" v-if="professionalData.lotacao === 'CREAS Regional'">
            <span class="text-grey">Unidade:</span> {{ professionalData.creas_regional }}
          </div>
          <div class="col-12" v-if="professionalData.lotacao === 'Subsecretaria de Assistência Social' && professionalData.superintendencia">
            <span class="text-grey">Superintendência/Assessoria:</span> {{ professionalData.superintendencia }}
          </div>

          <div class="col-12" v-if="professionalData.lotacao === 'Outros Públicos'">
            <span class="text-grey">Outros Públicos:</span> {{ professionalData.outros_publicos }} {{ professionalData.outros_publicos_others }}
          </div>

          <div class="col-12" v-if="professionalData.parceiros">
            <span class="text-grey">Parceiros:</span> {{ professionalData.parceiros }}
          </div>

          <div class="col-12" v-if="professionalData.superintendencia === '1' && professionalData.protecao_social_basica">
            <span class="text-grey">Diretorias:</span> {{ professionalData.protecao_social_basica }}
          </div>

          <div class="col-12" v-if="professionalData.superintendencia === '2' && professionalData.protecao_social_especial">
            <span class="text-grey">Diretorias:</span> {{ professionalData.protecao_social_especial }}
          </div>

          <div class="col-12" v-if="professionalData.superintendencia === '3' && professionalData.vigilancia_capacitacao">
            <span class="text-grey">Diretorias:</span> {{ professionalData.vigilancia_capacitacao }}
          </div>

          <div class="col-12" v-if="professionalData.lotacao === 'Ceas' && professionalData.funcao">
            <span class="text-grey">Função desempenhada:</span> {{ professionalData.funcao }}
          </div>

          <div class="col-12" v-if="professionalData.funcao">
            <span class="text-grey">Função desempenhada:</span> {{professionalData.funcao}}
          </div>
        </div>
        <!--Estadual-->

        <!--Municipal-->
        <div class="col-12 row q-col-gutter-y-md" v-if="professionalData.regional === 'Municipal' || professionalData.regional === '2'">
          <div class="col-12">
            <span class="text-grey">Ambito de atuação:</span> Municipal
          </div>

          <div class="col-12" v-if="secretaria">
            <span class="text-grey">Múnicipio:</span> {{ secretaria }}
          </div>
          <div class="col-12">
            <span class="text-grey">Órgão:</span> {{professionalData.orgao}}
          </div>
          <div class="col-12" v-if="professionalData.servicos_programa">
              <span class="text-grey">Serviço/Programa:</span> {{professionalData.servicos_programa}}
          </div>
          <div class="col-12" v-if="professionalData.servicos_programa_outro">
              <span class="text-grey">Outro - Serviço/Programa:</span> {{professionalData.servicos_programa_outro}}
          </div>
          <div class="col-12" v-if="professionalData.servicos_programa === 'Assessoria de gestão do Fundo Estadual de Assistência Social'">
            <div class="col-12">
              <span class="text-grey">Benefício</span> {{professionalData.beneficios_municipal}}
            </div>
            <div class="col-12" v-if="professionalData.beneficios_municipal === 'Outro'">
              <span class="text-grey">Outro - Benefícios:</span> {{professionalData.beneficios_municipal_outro}}
            </div>
          </div>
          <div class="col-12" v-if="professionalData.funcao">
            <span class="text-grey">Função desempenhada:</span> {{professionalData.funcao}}
          </div>
          <div class="col-12" v-if="professionalData.cargo">
            <span class="text-grey">Titularidade:</span> {{professionalData.cargo}}
          </div>
          <div class="col-12" v-if="professionalData.area_representada">
            <span class="text-grey">Representante:</span> {{professionalData.area_representada}}
          </div>
          <div class="col-12" v-if="professionalData.area_representada_outros">
            <span class="text-grey">Outro - Área representada:</span> {{professionalData.area_representada_outros}}
          </div>
          <div class="col-12" v-if="professionalData.area_de_atuacao">
            <span class="text-grey">Área de Atuação:</span> {{professionalData.area_de_atuacao}}
          </div>
          <div class="col-12" v-if="professionalData.protecao_social_especial_municipal">
            <span class="text-grey">Nível de Complexidade:</span> {{professionalData.protecao_social_especial_municipal}}
          </div>
          <div class="col-12" v-if="professionalData.vinculo_empregaticio">
            <span class="text-grey">Vínculo empregaticio:</span> {{professionalData.vinculo_empregaticio}}
          </div>
          <div class="col-12" v-if="professionalData.vinculo_empregaticio_outro">
            <span class="text-grey">Informe qual é o seu vínculo empregatício:</span> {{professionalData.vinculo_empregaticio_outro}}
          </div>
          <div class="col-12" v-if="professionalData.representacao_conselho">
            <span class="text-grey">Conselho:</span> {{professionalData.representacao_conselho}}
          </div>
          <div class="col-12" v-if="professionalData.representacao_representacao">
            <span class="text-grey">Segmento:</span> {{professionalData.representacao_representacao}}
          </div>
          <div class="col-12" v-if="professionalData.representacao_segmento">
            <span class="text-grey">Representação:</span> {{professionalData.representacao_segmento}}
          </div>
          <div class="col-12" v-if="professionalData.representacao_area_representada">
            <span class="text-grey">Outros - Área Representada:</span> {{professionalData.representacao_area_representada}}
          </div>
        </div>
        <!--Municipal-->
      </q-card-section>
    </q-card>
  </div>
  <ModalUserProfissional
    :dadosUser="dadosUser"
    :showModal="showModal"
    @update:show-modal="showModal = $event"
  ></ModalUserProfissional>
</template>

<script>
import ModalUserProfissional from "../../components/admin/modal/UserProfissional.vue";

export default {
  name: "UserProfissional",
  components: {
    ModalUserProfissional
  },
  props: {
    dadosUser: {},
  },
  emits: ['modalDadosProfissionaisFn'],
  data() {
    return {
      showModal: false
    };
  },
  computed: {
    user() {
      return this.dadosUser.user || {};
    },
    professionalData() {
      return this.dadosUser.professionalData || {};
    },
    secretaria() {
      return this.dadosUser.secretaria || false;
    }
  },
  methods: {
    modalDadosProfissionaisFn() {
      this.$emit('modalDadosProfissionaisFn');
    }
  }
};
</script>
