<template>
  <q-page class="bg-grey-1">
    <div class="q-pa-md">
      <div class="row" style="margin-bottom: 10px;">
        <div class="col-12">
          <q-btn class="bg-primary text-white" @click="voltarPagina" style="float: right;">
            Voltar
          </q-btn>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4 q-pa-xs">
          <q-card class="my-card">
            <q-card-section>
              <div class="text-h6">
                <q-icon name="sym_o_person" color="primary"/> {{ user.name }}
                <q-btn class="bg-primary text-caption text-white" @click="modalDadosPessoais = true" style="float: right;">
                  <font-awesome-icon :icon="['far', 'pen-to-square']" />
                  <q-tooltip
                    class="bg-primary text-caption outline"
                    :offset="[10, 10]"
                    style="max-width: 600px">
                      Editar informações do pessoais.
                  </q-tooltip>
                </q-btn>
              </div>
              <div>
                <q-chip size="sm" 
                  :text-color="chipTextColor"
                  :label="chipLabel"
                  :color="chipColor"
                />
                <q-chip v-if="user.type_admin == 1" size="sm"
                  :text-color="'white'"
                  :label="'Super Admin / Equipe DEP'"
                  :color="'primary'"
                />
                <q-chip v-if="user.type_admin == 2" size="sm"
                    :text-color="'white'"
                    :label="'SUBAS / Diretorias Regionais'"
                    :color="'primary'"
                />
                <q-chip v-if="user.type_admin == 3" size="sm"
                    :text-color="'white'"
                    :label="'Outros parceiros / Participantes'"
                    :color="'primary'"
                />
              </div>
            </q-card-section>
            <q-card-section>
              <div class="row">
                <div class="col-sm-12 q-pa-xs" v-if="user.secretaria">
                  <span class="text-grey">Secretaria</span> {{ user.secretaria }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="user.name">
                  <span class="text-grey">Nome</span> {{ user.name }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.social_name">
                  <span class="text-grey">Nome Social</span> {{ personal.social_name }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.gender_identity">
                  <span class="text-grey">Identidade de Gênero</span> {{ personal.gender_identity }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="user.birthday">
                  <span class="text-grey">Data de nascimento</span> {{ user.birthday }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="user.cpf">
                  <span class="text-grey">CPF</span> {{ user.cpf }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.rg">
                  <span class="text-grey">RG</span> {{ personal.rg }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.issuing_body">
                  <span class="text-grey">Orgão emissor</span> {{ personal.issuing_body }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.uf">
                  <span class="text-grey">UF</span> {{ personal.uf }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.education">
                  <span class="text-grey">Escolaridade</span> {{ personal.education }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.profission !== 'Outros' && personal.profission">
                  <span class="text-grey">Profissão</span> {{ personal.profission }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.profission === 'Outros'">
                  <span class="text-grey">Profissão</span> {{ personal.profission_others }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.is_deficiency">
                  <span class="text-grey">Deficiência</span> 
                  <span v-if="personal.deficiency !== 'Outros'"> {{ personal.deficiency }}</span>
                  <span v-if="personal.deficiency === 'Outros'"> {{ personal.deficiency_others }}</span>
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.deficiency_structure">
                  <span class="text-grey">Necessita de estrutura para participar da ação?</span> {{ personal.deficiency_structure }}
                </div>
              </div>
            </q-card-section>
          </q-card>

          <q-card class="my-card" style="margin-top: 15px;">
            <q-card-section>
              <h6 style="margin: 0; padding: 0;">Definir situação Cadastral</h6>
            </q-card-section>
            <q-card-section>
              <strong>Situação Cadastral:</strong>
              <q-select outlined :options="userPerfilStatus" v-model="user.status" @update:model-value="changeStatusUsuario($event)"/>
            </q-card-section>
          </q-card>

          <q-card class="my-card" style="margin-top: 15px;">
            <q-card-section>
              <h6 style="margin: 0; padding: 0;">Atribuíção de Perfil</h6>
            </q-card-section>
            <q-card-section>
              <q-btn color="green" outline @click="resetarSenhaUsuario">
                Resetar Senha
              </q-btn>
            </q-card-section>
            <q-card-actions>
              <strong style="margin: 0px 5px;">Tipo de perfil:</strong>
              <q-select outlined :options="tipoPerfilOptions" v-model="user.tipo_perfil" @update:model-value="changeTipoPerfilUsuario($event)" style="width: 98%; margin: 0px 5px;"/>
            </q-card-actions>
          </q-card>
        </div>
        <!-- modal dados pessoais -->
        <q-dialog v-model="modalDadosPessoais">
          <q-card style="width: 80%; max-width: 80vw;">
            <q-card-section>
              <h6 style="margin: 0; padding: 0;">Editar Dados Pessoais</h6>
            </q-card-section>
            <q-card-section>
              <div class="row q-col-gutter-md">
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-input
                    v-model="user.name"
                    for="name"
                    label="Nome e sobrenome"
                    name="name"
                    outlined
                    clear-icon="close"
                    clearable
                    :rules="[isRequired,isLetter]"
                  />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-input
                    v-model="user.cpf"
                    for="cpf"
                    label="CPF"
                    name="cpf"
                    outlined
                    clear-icon="close"
                    clearable
                    mask="###.###.###-##"
                    :rules="[isRequired]"
                  />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-input outlined v-model="user.birthday" label="Data de Nascimento">
                    <template v-slot:append>
                      <q-icon name="event" class="cursor-pointer">
                        <q-popup-proxy>
                          <q-date v-model="user.birthday" mask="DD/MM/YYYY"></q-date>
                        </q-popup-proxy>
                      </q-icon>
                    </template>
                  </q-input>
                </div>
                <div class="col-12">
                  <q-toggle v-model="checkSocialName"
                    >Nome social
                    <q-icon name="sym_o_info" size="1.2rem" color="primary">
                      <q-tooltip
                        class="bg-primary text-caption"
                        :offset="[10, 10]"
                        style="max-width: 600px"
                      >
                        Nome Social: designação pela qual a pessoa travesti ou
                        transexual se identifica e é socialmente reconhecida. (Conforme
                        Art.1° do DECRETO Nº 8.727, DE 28 DE ABRIL DE 2016)
                      </q-tooltip>
                    </q-icon></q-toggle
                  >
                </div>
                <div class="col-12" v-if="checkSocialName">
                  <q-input
                    v-model="user.social_name"
                    label="Nome Social"
                    name="socialName"
                    for="socialName"
                    outlined
                    clear-icon="close"
                    clearable
                    :rules="[isRequired, isLetter]"
                  />
                </div>
                <div class="col-12 row">
                  <div :class="activeGenderIdentityOthers ? 'col-lg-4 col-md-4 col-sm-12' : 'col-12'">
                    <q-select
                      v-model="user.gender_identity"
                      :options="genderIdentityList"
                      label="Identidade de genero"
                      name="genderIdentity"
                      for="genderIdentity"
                      outlined
                      clear-icon="close"
                      clearable
                      :rules="[isRequired]"
                    >
                      <template v-slot:prepend>
                        <q-icon name="sym_o_info" size="1.2rem" color="primary">
                          <q-tooltip
                            class="bg-primary text-caption"
                            :offset="[10, 10]"
                            style="max-width: 600px"
                          >
                            Identidade de Gênero: dimensão da identidade de uma pessoa
                            que diz respeito à forma como se relaciona com as
                            representações de masculinidade e feminilidade e como isso
                            se traduz em sua prática social, sem guardar relação
                            necessária com o sexo atribuído no nascimento.(Conforme
                            Art.1° do DECRETO Nº 8.727, DE 28 DE ABRIL DE 2016)
                          </q-tooltip>
                        </q-icon>
                      </template>
                    </q-select>
                  </div>
                  <div class="col-lg-4 col-md-8 col-sm-12 q-pl-sm" v-if="activeGenderIdentityOthers">
                    <q-input
                      v-model="user.gender_identity_others"
                      name="genderIdentityOthers"
                      for="genderIdentityOthers"
                      label="Outros"
                      outlined
                      clear-icon="close"
                      clearable
                      :rules="[isRequired]"
                    />
                  </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12">
                  <q-input
                    v-model="user.rg"
                    name="RG"
                    label="Numero do RG"
                    outlined
                    mask="##############################"
                    clear-icon="close"
                    clearable
                    :rules="[isNumber]"
                  />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-input
                    v-model="user.issuing_body"
                    label="Orgão emissor"
                    name="issuingBody"
                    outlined
                    clear-icon="close"
                    clearable
                    :rules="[isLetter]"
                  />
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                  <q-select
                    v-model="user.uf"
                    :options="ufFiltered"
                    label="UF"
                    name="uf"
                    outlined
                    use-input
                    input-debounce="0"
                    @filter="onUfFilter"
                    :rules="[isLetter]"
                  />
                </div>
                <div class="col-12">
                  <q-select
                    v-model="user.education"
                    :options="educationFiltered"
                    name="education"
                    for="education"
                    label="Escolaridade"
                    outlined
                    use-input
                    input-debounce="0"
                    @filter="onEducationFilter"
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                  />
                </div>
                <div class="col-12">
                  <q-select
                    v-model="user.profission"
                    :options="professionFiltered"
                    label="Profissão"
                    name="profession"
                    for="profession"
                    outlined
                    use-input
                    input-debounce="0"
                    @filter="onProfessionFilter"
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                  />
                </div>
                <div class="col-12" v-if="user.profession === 'Outros'">
                  <q-input
                    v-model="user.profission_others"
                    placeholder="Informe a outra profissão"
                    name="profissionOthers"
                    for="profissionOthers"
                    outlined
                    counter
                    maxlength="60"
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                  />
                </div>
                <div class="col-12">
                  <q-toggle v-model="isDeficiency" label="Possui alguma deficiência" />
                </div>
                <div class="col-12 row" v-if="isDeficiency">
                  <div :class="activeDeficiencyOthers ? 'col-4' : 'col-12'">
                    <q-select
                      v-model="user.deficiency"
                      name="deficiency"
                      for="deficiency"
                      :options="deficiencyFiltered"
                      label="Tipo de deficiência"
                      outlined
                      use-input
                      input-debounce="0"
                      @filter="onDeficiencyFilter"
                      clear-icon="close"
                      clearable
                      :rules="[isRequired]"
                    />
                  </div>
                  <div class="col-12" v-if="user.deficiency === 'Outros'">
                    <q-input
                      v-model="user.deficiency_others"
                      name="deficiencyOthers"
                      for="deficiencyOthers"
                      placeholder="informe o outro tipo de deficiência"
                      outlined
                      counter
                      maxlength="30"
                      clear-icon="close"
                      clearable
                      :rules="[isRequired]"
                    />
                  </div>
                </div>
                <div class="col-12 row" v-if="isDeficiency">
                  <div class="col-12">
                    <q-toggle
                      v-model="isDeficiencyStructure"
                      label="Necessita de estrutura para participar da ação?"
                    />
                  </div>
                  <div class="col-12 q-pl-sm" v-if="isDeficiencyStructure" style="margin-left: -0.5em; margin-top: 1em;">
                    <q-input
                      v-model="user.deficiency_structure"
                      placeholder="informe caso precise de uma estrutura de acesso."
                      outlined
                      name="deficiencyStructure"
                      for="deficiencyStructure"
                      counter
                      maxlength="200"
                      clear-icon="close"
                      clearable
                      :rules="[isRequired]"
                    />
                  </div>
                </div>
              </div>
            </q-card-section>
            <q-card-actions>
              <q-btn outlined label="Cancelar" color="red" v-close-popup style="float: left !important; margin-left:10px;" />
              <q-btn outlined label="Salvar" color="green" @click="salvarDadosPessoais" v-close-popup />
            </q-card-actions>
          </q-card>
        </q-dialog>
        <!-- fim da modal -->
        <div class="col-sm-8 q-pa-xs">
          <div class="col-sm-12">
            <q-card class="my-card">
              <q-card-section>
                <div class="text-h6">
                  <q-icon name="sym_o_home_work" color="primary"/> Dados Residenciais
                  <q-btn class="bg-primary text-caption text-white" @click="modalDadosResidenciais = true" style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip
                      class="bg-primary text-caption outline"
                      :offset="[10, 10]"
                      style="max-width: 600px">
                        Editar informações de residencia.
                    </q-tooltip>
                  </q-btn>
                </div>
              </q-card-section>
              <q-card-section>
                <div class="row" v-if="address.id">
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">CEP</span> {{ address.zip_code }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">Logradouro</span> {{ address.street }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">Número</span> {{ address.number }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">Bairro</span> {{ address.neighborhood }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="address.complement">
                    <span class="text-grey">Complemento</span> {{ address.complement }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">Cidade</span> {{ address.city }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">UF</span> {{ address.state }}
                  </div>
                </div>
                <div class="row" v-if="!address.id">
                  Não Cadastrado
                </div>
              </q-card-section>
            </q-card>
          </div>
          <!-- modal para edição de dados residenciais -->
          <q-dialog v-model="modalDadosResidenciais">
            <q-card style="width: 80%; max-width: 80vw;">
              <q-card-section>
                <h6 style="margin:0px; padding: 0px;">Editar Dados Residenciais</h6>
              </q-card-section>
              <q-card-section>
                <div class="row q-col-gutter-md">
                  <div class="col-12">
                    <q-input
                      v-model="address.zip_code"
                      label="Cep"
                      name="zip_code"
                      for="zip_code"
                      outlined
                      clear-icon="close"
                      clearable
                      mask="#####-###"
                      @blur="getAddressByZipCode"
                      value=""
                      :rules="[isRequired]"
                    />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-input
                    v-model="address.street"
                    label="Logradouro"
                    name="street"
                    for="street"
                    outlined
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                    />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-input
                    v-model="address.number"
                    label="Número"
                    name="number"
                    for="number"
                    outlined
                    clear-icon="close"
                    clearable
                    ref="number"
                    :rules="[isRequired, isNumber]"
                    />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-input
                    v-model="address.complement"
                    label="Complemeto"
                    outlined
                    clear-icon="close"
                    clearable
                    />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-input
                    v-model="address.neighborhood"
                    label="Bairro"
                    name="neighborhood"
                    for="neighborhood"
                    outlined
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                    />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-input
                    v-model="address.city"
                    label="Cidade"
                    name="city"
                    for="city"
                    outlined
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                    />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <q-select
                    v-model="address.state"
                    :options="stateFiltered"
                    label="UF"
                    name="state"
                    for="state"
                    outlined
                    use-input
                    input-debounce="0"
                    @filter="onStateFilter"
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                    />
                  </div>
                </div>
              </q-card-section>
              <q-card-actions>
                <q-btn outlined label="Cancelar" color="red" v-close-popup style="float: left !important; margin-left:10px;" />
                <q-btn outlined label="Salvar" color="green" @click="salvarDadosEndereco" v-close-popup />
              </q-card-actions>
            </q-card>
          </q-dialog>
          <!-- fim da modal -->
          <div class="col-sm-12 q-pt-sm">
            <q-card class="my-card">
              <q-card-section>
                <div class="text-h6">
                  <q-icon name="sym_o_call" color="primary"/> Contato
                  <q-btn class="bg-primary text-caption text-white" @click="modalDadosContato = true" style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip
                      class="bg-primary text-caption outline"
                      :offset="[10, 10]"
                      style="max-width: 600px">
                        Editar informações de contato.
                    </q-tooltip>
                  </q-btn>
                </div>
              </q-card-section>
              <q-card-section>
                <div class="row">
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">E-mail</span> {{ user.email }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="contact.phone">
                    <span class="text-grey">Telefone Residencial</span> {{ contact.phone }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="contact.cell_phone">
                    <span class="text-grey">Celular</span> {{ contact.cell_phone }} - <span class="text-grey">Whatsapp</span> {{ contact.cell_phone_whatsapp }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="contact.institutional_phone">
                    <span class="text-grey">Telefone Institucional</span> {{ contact.institutional_phone }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="contact.institutional_email">
                    <span class="text-grey">E-mail Institucional</span> {{ contact.institutional_email }}
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
          <!-- modal para edição de dados de contato -->
          <q-dialog v-model="modalDadosContato">
            <q-card style="width: 80%; max-width: 80vw;">
              <q-card-section>
                <h6 style="margin:0px; padding: 0px;">Editar Dados de Contato</h6>
              </q-card-section>
              <q-card-section>
                <div class="col-12">
                  <q-input
                    v-model="user.email"
                    label="Email*"
                    outlined
                    clear-icon="close"
                    name="email"
                    for="email"
                    disable
                    clearable
                    type="email"
                    :rules="[isRequired]"
                  />
                  </div>
                  <div class="col-12">
                    <q-input
                    v-model="contact.phone"
                    label="Telefone Residencial"
                    outlined
                    clear-icon="close"
                    mask="(##) ####-####"
                    :rules="[isPhoneNumber, notLessThanNormal, notMoreThanNormal]"
                    clearable
                    type="tel"
                  />
                  </div>
                  <div class="col-6">
                    <q-input
                      v-model="contact.cell_phone"
                      label="Nº Celular*"
                      name="cell_phone"
                      for="cell_phone"
                      outlined
                      clear-icon="close"
                      mask="(##) # ####-####"
                      :rules="[isRequired, isCellPhoneNumber, notLessThan, notMoreThan]"
                      clearable
                      type="tel"
                    />
                  </div>
                  <div class="col-6">
                    <q-select
                      v-model="contact.cell_phone_whatsapp"
                      name="cell_phone_whatsapp"
                      for="cell_phone_whatsapp"
                      label="Este número possui WhatsApp?"
                      :options="['Sim', 'Não']"
                      :rules="[isRequired]"
                      outlined
                    />
                  </div>
                  <div class="col-12">
                    <q-input
                      v-model="contact.institutional_phone"
                      label="Telefone Institucional"
                      outlined
                      clear-icon="close"
                      clearable
                      type="tel"
                      mask="(##) ####-####"
                      :rules="[isPhoneNumber, notLessThanNormal, notMoreThanNormal]"
                    />
                  </div>
                  <div class="col-12">
                    <q-input
                      v-model="contact.institutional_email"
                      label="Email Institucional"
                      outlined
                      clear-icon="close"
                      clearable
                      type="email"
                      :rules="[isEmail]"
                    />
                  </div>
              </q-card-section>
              <q-card-actions>
                <q-btn outlined label="Cancelar" color="red" v-close-popup style="float: left !important; margin-left:10px;" />
                <q-btn outlined label="Salvar" color="green" @click="salvarDadosContato" v-close-popup style="float: right !important;" />
              </q-card-actions>
            </q-card>
          </q-dialog>
          <!-- fim da modal -->
          <div class="col-sm-12 q-pt-sm">
            <q-card class="my-card">
              <q-card-section>
                <div class="text-h6">
                  <q-icon name="sym_o_work" color="primary"/> Profissionais
                  <q-btn class="bg-primary text-caption text-white" @click="modalDadosProfissionais = true" style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip
                      class="bg-primary text-caption outline"
                      :offset="[10, 10]"
                      style="max-width: 600px">
                        Editar informações de profissionais.
                    </q-tooltip>
                  </q-btn>
                </div>
              </q-card-section>
              <q-card-section>
                <!-- ESTADUAL -->
                <div class="col-12 row q-col-gutter-y-md" v-if="professionalData.regional === 'Estadual'">
                  <div class="col-12">
                    <span class="text-grey">Lotação:</span> {{professionalData.lotacao}}
                    </div>
                    <div class="col-12" v-if="professionalData.lotacao === 'Subsecretaria de Assistência Social'">
                      <span class="text-grey">Superintendência/Assessoria:</span> {{professionalData.superintendencia}}
                    </div>
                    <div class="col-12" v-if="professionalData.lotacao === 'Diretoria Regional de Desenvolvimento Social'">
                      <span class="text-grey">Diretorias:</span> {{professionalData.diretoria_regional_des_social}}
                    </div>
                    <div class="col-12" v-if="professionalData.lotacao === 'CREAS Regional'">
                      <span class="text-grey">Unidade:</span> {{professionalData.creas_regional}}
                    </div>
                  <div class="col-12" v-if="professionalData.lotacao === 'Outros Públicos'">
                    <span class="text-grey">Órgão de Atuação:</span> {{professionalData.outros_publicos}}
                  </div>
                  <div class="col-12" v-if="professionalData.outros_publicos === 'Outros'">
                    <span class="text-grey">Outro órgão de atuação:</span> {{professionalData.outros_publicos_outro}}
                  </div>
                  <div class="col-12" v-if="professionalData.lotacao === 'Perceiros (Inscrição Interna)'">
                    <span class="text-grey">Parceiros:</span> {{professionalData.parceiros_insc_interna}}
                  </div>
                  <div class="col-12" v-if="professionalData.superintendencia === 'Superintendência de Proteção Social Básica'">
                    <span class="text-grey">Diretorias:</span> {{professionalData.protecao_social_basica}}
                    
                  </div>
                  <div class="col-12" v-if="professionalData.superintendencia === 'Superintendência de Proteção Social Especial'">
                    <span class="text-grey">Diretorias:</span> {{professionalData.protecao_social_especial_estadual}}
                  </div>
                  <div class="col-12" v-if="professionalData.superintendencia === 'Superintendência de Vigilância e Capacitação'">
                    <span class="text-grey">Diretorias:</span> {{professionalData.vigilancia_capacitacao}}
                  </div>
                  <div class="col-12" v-if="professionalData.regional === 'Estadual'">
                    <span class="text-grey">Função desempenhada:</span> {{professionalData.funcao}}
                  </div>
                  <div class="col-12" v-if="professionalData.funcao === 'Conselheiro'">
                    <span class="text-grey">Segmento:</span> {{professionalData.ceas_representacao}}
                  </div>
                  <div class="col-12" v-if="professionalData.ceas_representacao === 'Governamental'">
                    <div class="col-12">
                      <span class="text-grey">Representação:</span> {{professionalData.seguimento_governo}}
                    </div>
                    <div class="col-12" v-if="professionalData.seguimento_governo === 'Representante Governamental'">
                      <span class="text-grey">Área Representada:</span> {{professionalData.representacao_area_representada}}
                    </div>
                    <div class="col-12" v-if="professionalData.representacao_area_representada === 'Outros'">
                      <span class="text-grey">Área Representada Outros:</span> {{professionalData.outros_representacao_area_representada}}
                    </div>
                  </div>    
                  <div class="col-12" v-if="professionalData.seguimento_governo === 'Outro'">
                    <span class="text-grey">Representação:</span> {{professionalData.ceas_segmento}}    
                  </div>
                  <div class="col-12" v-if="professionalData.ceas_representacao === 'Sociedade Civil'">
                    <span class="text-grey">Representação:</span> {{professionalData.ceas_segmento}}
                  </div>
                  <div class="col-12" v-if="professionalData.funcao === 'Outro'">
                    <span class="text-grey">Função Outro:</span> {{professionalData.funcao_outro}}
                  </div>

                  <div class="col-12" v-if="professionalData.funcao === 'Conselheiro'">
                    <span class="text-grey">Titularidade:</span> {{ professionalData.ceas_titularidade }}
                  </div>
                </div>
                <!-- FIM ESTADUAL -->
                <!-- MUNICIPAL -->
                <div class="col-12 row q-col-gutter-y-md" v-if="professionalData.regional === 'Municipal'">
                  <div class="col-12">
                    <span class="text-grey">Órgão:</span> {{professionalData.orgao}}
                  </div>
                  <!-- Opções de input dependendo do valor do campo Orgão -->
                  <div class="col-12" v-if="professionalData.orgao === 'Conselho Municipal de Assistência Social'">
                    <span class="text-grey">Função desempenhada:</span> {{professionalData.funcao}}
                  </div>
                  <div class="col-12" v-else-if="professionalData.orgao && professionalData.orgao !== 'Conselho Tutelar'">
                    <span class="text-grey">Função desempenhada:</span> {{professionalData.funcao}}
                  </div>
                  <!-- Opções de input dependendo do valor do campo Orgão -->
                  <div class="col-12" v-if="professionalData.funcao === 'Conselheiro'">
                    <span class="text-grey">Segmento:</span> {{professionalData.representante}}
                  </div>                    
                  <div class="col-12" v-if="professionalData.orgao === 'Secretaria Municipal de Assistência Social'">
                    <span class="text-grey">Área de atuação:</span> {{professionalData.area_de_atuacao}}
                    <!-- Opções de input dependendo do valor do campo Área de atuação -->
                    <div class="col-12" v-if="professionalData.area_de_atuacao === 'Proteção Social Básica'">
                      <span class="text-grey">Serviço/Programa:</span> {{professionalData.servicos_programa}}
                    </div>
                  </div>
                  <!-- Opções de input dependendo do valor do campo Serviço/Programa -->
                  <div class="col-12" v-if="professionalData.servicos_programa === 4">
                    <div class="col-12">
                      <span class="text-grey">Benefício</span> {{professionalData.beneficios_municipal}}
                    </div>
                    <div class="col-12" v-if="professionalData.beneficios_municipal === 'Outro'">
                      <span class="text-grey">Outro - Benefícios:</span> {{professionalData.beneficios_municipal_outro}}
                    </div>
                  </div>
                  <!-- Opções de input dependendo do valor do campo Representante -->
                  <div class="col-12" v-if="professionalData.representante === 'Governamental'">
                    <div class="col-12">
                      <span class="text-grey">Representação:</span> {{professionalData.area_representada}}
                    </div>

                    <div class="col-12" v-if="professionalData.area_representada === 'Outro'">
                      <span class="text-grey">Outro - Área representada:</span> {{professionalData.area_representada_outro}}
                    </div>
                  </div>
                  <div class="col-12" v-if="professionalData.representante === 'Sociedade Civil'">
                    <span class="text-grey">Representação:</span> {{professionalData.area_representada}}
                  </div>
                  <div class="col-12" v-if="professionalData.orgao === 'Entidades e Organizações de Assistência Social'">
                    <span class="text-grey">Área de Atuação:</span> {{professionalData.area_de_atuacao}}
                  </div>
                  <!-- Opções de input dependendo do valor do campo Área de Atuacao -->
                  <div class="col-12" v-if="professionalData.area_de_atuacao === 'Proteção Social Básica'">
                    <span class="text-grey">Área de Atuação:</span> {{professionalData.area_de_atuacao}}
                  </div>

                  <div class="col-12" v-if="professionalData.area_de_atuacao === 'Proteção Social Especial'">
                    <span class="text-grey">Nível de Complexidade:</span> {{professionalData.protecao_social_especial_municipal}}      
                  </div>
                  <!-- Opções de input dependendo do valor do campo Proteção Social Especial -->
                  <div class="col-12" v-if="professionalData.protecao_social_especial_municipal === 'Média Complexidade'">
                    <div class="col-12">
                      <span class="text-grey">Serviço/Programa:</span> {{professionalData.servicos_programa}}
                    </div>
                  </div>
                  <div class="col-12" v-else>
                    <div class="col-12" v-if="professionalData.area_de_atuacao === 'Proteção Social Especial'">
                      <span class="text-grey">Serviço/Programa:</span> {{professionalData.servicos_programa}}
                    </div>
                  </div>
                  <!-- Opções de input dependendo do valor do campo Área de atuação -->
                  <div class="col-12" v-if="professionalData.area_de_atuacao === 'Gestão do SUAS'">
                    <div class="col-12">
                      <span class="text-grey">Serviço/Programa:</span> {{professionalData.servicos_programa}}
                    </div>
                    <div class="col-12" v-if="professionalData.servicos_programa === 'Outro'">
                      <span class="text-grey">Outro - Serviço/Programa:</span> {{professionalData.servicos_programa_outro}}
                    </div>
                  </div>
                  <!-- Opções de input dependendo do valor do campo Área de atuação -->
                  <div class="col-12" v-if="professionalData.area_de_atuacao === 'Gestão do SUAS'">
                    <div class="col-12" v-if="professionalData.servicos_programa === 'Outro'">
                      <span class="text-grey">Outro - Serviço/Programa:</span> {{professionalData.servicos_programa_outro}}
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="col-12" v-if="professionalData.area_representada">
                      <span class="text-grey">Área Representada:</span> {{professionalData.area_representada}}
                    </div>
                    <div class="col-12" v-if="professionalData.area_representada_outro">
                      <span class="text-grey">Outro - Área Representada:</span> {{professionalData.area_representada_outro}}
                    </div>
                  </div>
                  <div class="col-12" v-if="professionalData.area_representada !== ''">
                    <span class="text-grey">Titularidade:</span> {{professionalData.cargo}}
                  </div>
                </div>
                <!-- FIM MUNICIPAL -->

                <div class="col-12" v-if="professionalData.funcao === 'Secretaria Executiva'">
                  <span class="text-grey">Vínculo empregaticio:</span> {{professionalData.vinculo_empregaticio}}
                </div>
                <div class="col-12" v-if="professionalData.vinculo_empregaticio === 'Outro'">
                  <span class="text-grey">Outro - Vínculo empregaticio:</span> {{professionalData.vinculo_empregaticio_outro}}
                </div>
                <div class="col-12" v-if="professionalData.possui_representacao">
                  <div class="col-12">
                    <span class="text-grey">Conselho:</span> {{professionalData.representacao_conselho}}
                  </div>
                  <div class="col-12">
                    <span class="text-grey">Segmento:</span> {{professionalData.representacao_representacao}}
                  </div>
                  <div class="col-12" v-if="professionalData.representacao_conselho === 'Conselho Estadual de Assistência Social (CEAS)'">
                    <div class="col-12" v-if="professionalData.representacao_representacao === 'Representante Governamental'">
                      <span class="text-grey">Representação:</span> {{professionalData.representacao_segmento}}
                    </div>

                    <div class="col-12" v-if="professionalData.representacao_representacao === 'CMAS Governamental'">
                      <span class="text-grey">Representação:</span> {{professionalData.representacao_segmento}}
                    </div>
                    <div class="col-12" v-if="professionalData.representacao_segmento === 'Usuários de Assistencia Social'">
                      <span class="text-grey">Área Representada:</span> {{professionalData.representacao_area_representada}}
                    </div>

                    <div class="col-12" v-if="professionalData.representacao_area_representada === 'Outros'">
                      <span class="text-grey">Outro - Área Representada</span> {{professionalData.outros_representacao_area_representada}}
                    </div>
                  </div>
                  <div class="col-12" v-else>
                    <div class="col-12" v-if="professionalData.representacao_representacao === 'Representante Governamental'">
                      <span class="text-grey">Representação:</span> {{professionalData.representacao_segmento}}
                    </div>
                    <div class="col-12" v-if="professionalData.representacao_representacao === 'CMAS Governamental'">
                      <span class="text-grey">Representação:</span> {{professionalData.representacao_segmento}}
                    </div>
                  </div>
                  <div class="col-12">
                    <span class="text-grey">Titularidade:</span> {{professionalData.representacao_titularidade}}
                  </div>
                </div>
              </q-card-section>
            </q-card>
            <!-- inicio modal dados profissionais -->
            <q-dialog v-model="modalDadosProfissionais">
              <q-card style="width: 80%; max-width: 80vw;">
                <q-card-section>
                  <h6 style="margin:0px; padding: 0px;">Editar Dados Profissionais</h6>
                </q-card-section>
                <q-card-section>
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <q-select 
                        outlined
                        v-model="user.service"
                        :options="services"
                        label="Ambito de Atuação"
                        :rules="[isRequired]"
                        lazy-rules
                        style="padding: 0 5px"
                        emit-value
                        map-options
                      >
                        <template v-slot:prepend>
                          <q-icon name="corporate_fare" class="cursor-pointer" />
                        </template>
                        <template v-slot:no-option>
                          <q-item>
                            <q-item-section class="text-grey">
                              Nenhum item disponível
                            </q-item-section>
                          </q-item>
                        </template>
                        <template v-slot:options="{ option, selected }">
                          <q-item :key="option.value" v-if="option.value === '1' || option.value === '2'">
                            <q-item-section>
                              <q-item-label v-if="selected">
                                {{ option.label }}
                              </q-item-label>
                            </q-item-section>
                          </q-item>
                        </template>
                      </q-select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <q-select
                        v-show="user.service !== null"
                        outlined
                        v-model="user.secretaria"
                        :options="user.service=== '2' ? filterMunicipios : filterSecretaries"
                        :label="user.service === '2' ? 'Município' : 'Lotação'"
                        @filter="filterFn"
                        :rules="[isRequired]"
                        lazy-rules
                        emit-value
                        map-options
                        input-debounce="0"
                      >
                        <template v-slot:prepend>
                          <q-icon name="mdi-domain" class="cursor-pointer" />
                        </template>

                        <template v-slot:no-option>
                          <q-item>
                            <q-item-section class="text-grey">
                              Sem resultados!
                            </q-item-section>
                          </q-item>
                        </template>
                      </q-select>
                    </div>
                  </div>
                </q-card-section>
                <q-card-section>
                  <div class="row">
                    <!-- ESTADUAL -->
                    <div class="col-12 row q-col-gutter-y-md" v-if="professional.regional === 'Estadual'">
                      <div class="col-12">
                        <q-select
                            v-model="professionalData.lotacao"
                            :options="filterLotacao"
                            label="Lotação*"
                            name="lotacao"
                            for="lotacao"
                            outlined
                            :rules="[isRequired]"
                            disable />
                        </div>
                        <div class="col-12" v-if="professional.lotacao === 'Subsecretaria de Assistência Social'">
                          <q-select
                            v-model="professionalData.superintendencia"
                            :options="superintendenciaList"
                            label="Superintendência/Assessoria*"
                            name="superintendencia"
                            for="superintendencia"
                            outlined
                            :rules="[isRequired]" />
                        </div>
                        <div class="col-12" v-if="professional.lotacao === 'Diretoria Regional de Desenvolvimento Social'">
                          <q-select
                            v-model="professionalData.diretoria_regional_des_social"
                            :options="diretoriaRegionalDesSocialList"
                            label="Diretorias*"
                            name="diretoriaRegionalDesSocial"
                            for="diretoriaRegionalDesSocial"
                            outlined
                            :rules="[isRequired]" />
                        </div>
                        <div class="col-12" v-if="professional.lotacao === 'CREAS Regional'">
                          <q-select
                            v-model="professional.creas_regional"
                            :options="creasRegionalList"
                            label="Unidade*"
                            name="creasRegional"
                            for="creasRegional"
                            outlined
                            :rules="[isRequired]" />
                        </div>
                      <div class="col-12" v-if="professional.lotacao === 'Outros Públicos'">
                        <q-select
                          v-model="professional.outros_publicos"
                          :options="outrosPublicosList"
                          name="outrosPublicos"
                          for="outrosPublicos"
                          label="Órgão de Atuação*"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.outros_publicos === 'Outros'">
                        <q-input
                          v-model="professional.outros_publicos_outro"
                          label="Informe qual é o seu órgão de atuação*"
                          name="outrosPublicosOutro"
                          for="outrosPublicosOutro"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.lotacao === 'Perceiros (Inscrição Interna)'">
                        <q-select
                          v-model="professional.parceiros_insc_interna"
                          :options="parceirosInscInternaList"
                          label="Parceiros*"
                          name="parceirosInscInterna"
                          for="parceirosInscInterna"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.superintendencia === 'Superintendência de Proteção Social Básica'">
                        <q-select
                          v-model="professional.protecao_social_basica"
                          :options="protecaoSocialBasicaList"
                          label="Diretorias*"
                          name="protecaoSocialBasica"
                          for="protecaoSocialBasica"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.superintendencia === 'Superintendência de Proteção Social Especial'">
                        <q-select
                          v-model="professional.protecao_social_especial_estadual"
                          :options="protecaoSocialEspecialEstadualList"
                          label="Diretorias*"
                          name="protecaoSocialEspecialEstadual"
                          for="protecaoSocialEspecialEstadual"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.superintendencia === 'Superintendência de Vigilância e Capacitação'">
                        <q-select
                          v-model="professional.vigilancia_capacitacao"
                          :options="vigilanciaCapacitacaoList"
                          label="Diretorias*"
                          name="vigilanciaCapacitacao"
                          for="vigilanciaCapacitacao"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.regional === 'Estadual'">
                        <div v-if="professional.lotacao === 'Ceas'">
                          <q-select
                            v-model="professional.funcao"
                            :options="funcaoDesempenhadaCeasList"
                            label="Função desempenhada*"
                            name="funcao"
                            for="funcao"
                            outlined
                            :rules="[isRequired]" />
                        </div>
                        <div v-else>
                          <q-select
                            v-model="professional.funcao"
                            :options="funcaoDesempenhadaList"
                            label="Função desempenhada*"
                            name="funcao"
                            for="funcao"
                            outlined
                            :rules="[isRequired]" />
                        </div>
                      </div>
                      <div class="col-12" v-if="professional.funcao === 'Conselheiro'">
                        <q-select
                          v-model="professional.ceas_representacao"
                          :options="funcaoDesempenhadaSecratariaList"
                          label="Segmento*"
                          name="segmento"    
                          for="segmento"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.ceas_representacao === 'Governamental'">
                        <div class="col-12">
                          <q-select 
                            v-model="professional.seguimento_governo"
                            :options="representacaoRepresentacaoList"
                            label="Representação*"
                            name="representação"
                            for="representação"
                            outlined
                            :rules="[isRequired]" />
                        </div>
                        <div class="col-12" v-if="professional.seguimento_governo === 'Representante Governamental'">
                          <q-select
                            v-model="professional.representacao_area_representada"
                            :options="representacaoAreaRepresentadaList"
                            label="Área Representada*"
                            name="representacaoAreaRepresentada"
                            for="representacaoAreaRepresentada"
                            outlined
                            clearable
                            :rules="[isRequired]" />
                        </div>
                        <div class="col-12" v-if="professional.representacao_area_representada === 'Outros'">
                          <q-input
                            v-model="professional.outros_representacao_area_representada"
                            label="Informe qual é o sua área representada*"
                            name="outrosRepresentacaoAreaRepresentada"
                            for="outrosRepresentacaoAreaRepresentada"
                            outlined
                            :rules="[isRequired]" />
                        </div>
                      </div>    
                      <div class="col-12" v-if="professional.seguimento_governo === 'Outro'">
                        <q-input
                          v-model="professional.ceas_segmento"
                          label="Representação*"
                          name="representação"
                          for="representação"
                          outlined
                          counter
                          maxlength="30"
                          clear-icon="close"
                          clearable
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.ceas_representacao === 'Sociedade Civil'">
                        <q-select
                          v-model="professional.ceas_segmento"
                          :options="representacaoSegmentoList"
                          label="Representação*"
                          name="representação"
                          for="representação"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.funcao === 'Outro'">
                        <q-input
                          v-model="professional.funcao_outro"
                          label="Função Outro*"
                          name="funcaoOutro"
                          for="funcaoOutro"
                          outlined
                          placeholder="Função Outro"
                          counter
                          maxlength="50"
                          clear-icon="close"
                          clearable
                          :rules="[isRequired]" />
                      </div>

                      <div class="col-12" v-if="professional.funcao === 'Conselheiro'">
                        <q-select
                          v-model="professional.ceas_titularidade"
                          :options="funcaoDesempenhadaConselheiroList"
                          label="Titularidade*"
                          name="titularidade"
                          for="titularidade"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                    </div>
                    <!-- FIM ESTADUAL -->
                    <!-- MUNICIPAL -->
                    <div class="col-12 row q-col-gutter-y-md" v-if="professional.regional === 'Municipal'">
                      <div class="col-12">
                        <q-select
                          v-model="professional.orgao"
                          label="Orgão*"
                          name="orgao"
                          for="orgao"
                          outlined
                          :options="orgaoList" />
                      </div>

                      <!-- Opções de input dependendo do valor do campo Orgão -->
                      <div class="col-12" v-if="professional.orgao === 'Conselho Municipal de Assistência Social'">
                          <!-- Opções para Conselheiro Municipal -->
                          <q-select
                              v-model="professional.funcao"
                              :options="funcaoDesempenhadaCeasList"
                              label="Função desempenhada*"
                              name="funcao"
                              for="funcao"
                              outlined
                              :rules="[isRequired]"
                          />
                      </div>
                      <div class="col-12" v-else-if="professional.orgao && professional.orgao !== 'Conselho Tutelar'">
                        <q-select
                          v-model="professional.funcao"
                          :options="funcaoDesempenhadaList"
                          label="Função desempenhada*"
                          name="funcao"
                          for="funcao"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <!-- Opções de input dependendo do valor do campo Orgão -->
                      <div class="col-12" v-if="professional.funcao === 'Conselheiro'">
                        <q-select
                          v-model="professional.representante"
                          :options="representanteList"
                          label="Segmento*"
                          name="representante"
                          for="representante"
                          outlined
                          :rules="[isRequired]" />
                      </div>                    

                      <div class="col-12" v-if="professional.orgao === 'Secretaria Municipal de Assistência Social'">
                        <q-select 
                          v-model="professional.area_de_atuacao"
                          :options="areadeAtuacaoList1"
                          label="Área de atuação*"
                          name="areadeAtuacao"
                          for="areadeAtuacao"
                          outlined
                          clearable
                          :rules="[isRequired]" />

                          <!-- Opções de input dependendo do valor do campo Área de atuação -->
                          <div class="col-12" v-if="professional.area_de_atuacao === 'Proteção Social Básica'">
                            <q-select
                              v-model="professional.servicos_programa"
                              :options="protecaoSocialList"
                              label="Serviço/Programa*"
                              name="servicosPrograma"
                              for="servicosPrograma"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                        </div>

                        <!-- Opções de input dependendo do valor do campo Serviço/Programa -->
                        <div class="col-12" v-if="professional.servicos_programa === 'Gestão de Benefícios Socioassistenciais/Cad. Único'">
                          <div class="col-12">
                            <q-select
                              v-model="professional.beneficios_municipal"
                              :options="beneficioslList"
                              label="Benefício*"
                              name="beneficiosMunicipal"
                              for="beneficiosMunicipal"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                          <div class="col-12" v-if="professional.beneficios_municipal === 'Outro'">
                            <q-input
                              v-model="professional.beneficios_municipal_outro"
                              label="Outro - Benefícios*"
                              name="beneficiosMunicipalOutro"
                              for="beneficiosMunicipalOutro"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                        </div>

                        <!-- Opções de input dependendo do valor do campo Representante -->
                        <div class="col-12" v-if="professional.representante === 'Governamental'">
                          <div class="col-12">
                            <q-select
                              v-model="professional.area_representada"
                              :options="representacaoGovernamentalConselheiroList"
                              label="Representação*"
                              name="areaRepresentada"
                              for="areaRepresentada"
                              outlined
                              clearable
                              :rules="[isRequired]" />
                          </div>

                          <div class="col-12" v-if="professional.area_representada === 'Outro'">
                            <q-input
                              v-model="professional.area_representada_outro"
                              label="Outro - Área representada*"
                              name="areaRepresentadaOutro"
                              for="areaRepresentadaOutro"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                        </div>
                        <div class="col-12" v-if="professional.representante === 'Sociedade Civil'">
                          <q-select
                            v-model="professional.area_representada"
                            :options="areaRepresentadaCivilList"
                            label="Representação*"
                            name="areaRepresentada"
                            for="areaRepresentada"
                            outlined
                            :rules="[isRequired]" />
                        </div>

                        <div class="col-12" v-if="professional.orgao === 'Entidades e Organizações de Assistência Social'">
                          <q-select
                            v-model="professional.area_de_atuacao"
                            :options="areadeAtuacaoList2"
                            label="Área de Atuação*"
                            name="areadeAtuacao"
                            for="areadeAtuacao"
                            outlined
                            :rules="[isRequired]" />
                        </div>

                        <!-- Opções de input dependendo do valor do campo Área de Atuacao -->
                        <div class="col-12" v-if="professional.area_de_atuacao === 'Proteção Social Básica'">
                          <q-select
                            v-model="professional.area_de_atuacao"
                            :options="areadeAtuacaoList2"
                            label="Área de Atuação*"
                            name="areadeAtuacao"
                            for="areadeAtuacao"
                            outlined
                            :rules="[isRequired]" />
                        </div>

                        <div class="col-12" v-if="professional.area_de_atuacao === 'Proteção Social Especial'">
                          <q-select
                            v-model="professional.protecao_social_especial_municipal"
                            :options="protecaoSocialEspecialMunicipalList"
                            label="Nível de Complexidade*"
                            name="protecaoSocialEspecialMunicipal"
                            for="protecaoSocialEspecialMunicipal"
                            outlined
                            :rules="[isRequired]" />
                        </div>

                        <!-- Opções de input dependendo do valor do campo Proteção Social Especial -->
                        <div class="col-12" v-if="professional.protecao_social_especial_municipal === 'Média Complexidade'">
                          <div class="col-12">
                            <q-select
                              v-model="professional.servicos_programa"
                              :options="socialEspecialMediaComplexidadeList"
                              label="Serviço/Programa*"
                              name="servicosPrograma"
                              for="servicosPrograma"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                        </div>
                        <div class="col-12" v-else>
                          <div class="col-12" v-if="professional.area_de_atuacao === 'Proteção Social Especial'">
                            <q-select
                              v-model="professional.servicos_programa"
                              :options="socialEspecialAltaComplexidadeList"
                              label="Serviço/Programa*"
                              name="servicosPrograma"
                              for="servicosPrograma"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                        </div>
                        <!-- Opções de input dependendo do valor do campo Área de atuação -->
                        <div class="col-12" v-if="professional.area_de_atuacao === 'Gestão do SUAS'">
                          <div class="col-12">
                            <q-select
                              v-model="professional.servicos_programa"
                              :options="gestaoDoSuasList"
                              label="Serviço/Programa*"
                              name="servicosPrograma"
                              for="servicosPrograma"
                              outlined
                              :rules="[isRequired]" />
                          </div>

                          <div class="col-12" v-if="professional.servicos_programa === 'Outro'">
                            <q-input
                              v-model="professional.servicos_programa_outro"
                              label="Outro - Serviço/Programa*"
                              name="servicosProgramaOutro"
                              for="servicosProgramaOutro"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                        </div>

                        <!-- Opções de input dependendo do valor do campo Área de atuação -->
                        <div class="col-12" v-if="professional.area_de_atuacao === 'Gestão do SUAS'">
                          <div class="col-12" v-if="professional.servicos_programa === 'Outro'">
                            <q-input
                              v-model="professional.servicos_programa_outro"
                              label="Outro - Serviço/Programa*"
                              name="servicosProgramaOutro"
                              for="servicosProgramaOutro"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                          <div class="col-12">
                            <q-select
                              v-model="professional.servicos_programa"
                              :options="gestaoFinanceiraOrcamentariaSuasList"
                              label="Serviço/Programa*"
                              name="servicosPrograma"
                              for="servicosPrograma"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                        </div>
                        <div class="col-12" v-if="false">
                          <div class="col-12">
                            <q-select
                              v-model="professional.area_representada"
                              :options="representacaoAreaRepresentadaList"
                              label="Área Representada*"
                              name="areaRepresentada"
                              for="areaRepresentada"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                          <div class="col-12" v-if="professional.area_representada_outro">
                            <q-input
                              v-model="professional.area_representada_outro"
                              label="Outro - Área Representada*"
                              name="areaRepresentadaOutro"
                              for="areaRepresentadaOutro"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                        </div>
                        <div class="col-12" v-if="professional.area_representada !== ''">
                          <q-select
                            v-model="professional.cargo"
                            :options="cargoList"
                            label="Titularidade*"
                            name="cargo"
                            for="cargo"
                            outlined
                            :rules="[isRequired]" />
                        </div>
                    </div>
                    <!-- FIM MUNICIPAL -->
                    <div class="col-12" v-if="professional.funcao === 'Secretaria Executiva'">
                      <q-select
                        v-model="professional.vinculo_empregaticio"
                        :options="vinculoEmpregaticioList"
                        label="Vínculo empregaticio*"
                        name="vinculoEmpregaticio"
                        for="vinculoEmpregaticio"
                        outlined
                        :rules="[isRequired]" />
                    </div>
                    <div class="col-12" v-if="professional.vinculo_empregaticio === 'Outro'">
                      <q-input
                        v-model="professional.vinculo_empregaticio_outro"
                        label="Informe qual é o seu vínculo empregatício*"
                        name="vinculoEmpregaticioOutro"
                        for="vinculoEmpregaticioOutro"
                        outlined
                        :rules="[isRequired]" />
                    </div>
                    <div class="col-12" v-if="professional.regional === 'Municipal' && professional.orgao !== 'Conselho Tutelar'">
                      <q-toggle
                        v-model="professional.possui_representacao"
                        label="Possui também alguma representação em conselho de assistência social (municipal ou estadual)?" />
                    </div>
                    <div class="col-12" v-if="professional.possui_representacao">
                      <div class="col-12" v-if="professional.orgao === 'Conselho Municipal de Assistência Social'">
                        <q-select
                          v-model="professional.representacao_conselho"
                          :options="representacaoConselhoList"
                          label="Conselho*"
                          name="representacaoConselho"
                          for="representacaoConselho"
                          outlined
                          :rules="[isRequired]"/>
                      </div>
                      <div class="col-12" v-else>
                        <q-select
                          v-model="professional.representacao_conselho"
                          :options="representacaoConselhoCMASList"
                          label="Conselho*"
                          name="representacaoConselho"
                          for="representacaoConselho"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12">
                        <q-select
                          v-model="professional.representacao_representacao"
                          :options="representanteList"
                          label="Segmento*"
                          name="representacaoRepresentacao"
                          for="representacaoRepresentacao"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                      <div class="col-12" v-if="professional.representacao_conselho === 'Conselho Estadual de Assistência Social (CEAS)'">
                        <div class="col-12" v-if="professional.representacao_representacao === 'Representante Governamental'">
                          <q-select
                            v-model="professional.representacao_segmento"
                            :options="representacaoRepresentacaoList"
                            label="Representação*"
                            name="representacaoSegmento"
                            for="representacaoSegmento"
                            outlined
                            clearable
                            :rules="[isRequired]" />
                          </div>

                          <div class="col-12" v-if="professional.representacao_representacao === 'CMAS Governamental'">
                            <q-select
                              v-model="professional.representacao_segmento"
                              :options="representacaoSegmentoList"
                              label="Representação*"
                              name="representacaoSegmento"
                              for="representacaoSegmento"
                              outlined
                              clearable
                              :rules="[isRequired]" />
                          </div>
                          <div class="col-12" v-if="professional.representacao_segmento === 'Usuários de Assistencia Social'">
                            <q-select
                              v-model="professional.representacao_area_representada"
                              :options="representacaoAreaRepresentadaList"
                              label="Área Representada*"
                              name="representacaoAreaRepresentada"
                              for="representacaoAreaRepresentada"
                              outlined
                              clearable
                              :rules="[isRequired]" />
                          </div>

                          <div class="col-12" v-if="professional.representacao_area_representada === 'Outros'">
                            <q-input
                              v-model="professional.outros_representacao_area_representada"
                              label="Informe qual é o sua área representada*"
                              name="outrosRepresentacaoAreaRepresentada"
                              for="outrosRepresentacaoAreaRepresentada"
                              outlined
                              :rules="[isRequired]" />
                          </div>
                      </div>
                      <div class="col-12" v-else>
                        <div class="col-12" v-if="professional.representacao_representacao === 'Representante Governamental'">
                          <q-select
                            v-model="professional.representacao_segmento"
                            :options="representacaoGovernamentalConselheiroList"
                            label="Representação*"
                            name="representacaoSegmento"
                            for="representacaoSegmento"
                            outlined
                            clearable
                            :rules="[isRequired]" />
                        </div>
                        <div class="col-12" v-if="professional.representacao_representacao === 'CMAS Governamental'">
                          <q-select
                            v-model="professional.representacao_segmento"
                            :options="areaRepresentadaCivilList"
                            label="Representação*"
                            name="representacaoSegmento"
                            for="representacaoSegmento"
                            outlined
                            clearable
                            :rules="[isRequired]" />
                        </div>
                      </div>
                      <div class="col-12">
                        <q-select
                          v-model="professional.representacao_titularidade"
                          :options="representacaoTitularidadeList"
                          label="Titularidade*"
                          name="representacaoTitularidade"
                          for="representacaoTitularidade"
                          outlined
                          :rules="[isRequired]" />
                      </div>
                    </div>
                  </div>
                </q-card-section>
                <q-card-actions>
                  <q-btn outlined label="Cancelar" color="red" v-close-popup style="float: left !important; margin-left:10px;" />
                  <q-btn outlined label="Salvar" color="green" @click="salvarDadosProfissionais" v-close-popup style="float: right !important;" />
                </q-card-actions>
              </q-card>
            </q-dialog>
          </div>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
import { ref } from 'vue'
import accountMixin from "../../mixins/accountMixin";
import axios from "axios";
import Swal from 'sweetalert2'

export default {
  setup () {
    return {
      tab: ref('dados_pessoais'),
      modalDadosResidenciais: ref(false),
      modalDadosContato: ref(false),
      modalDadosPessoais: ref(false),
      modalDadosProfissionais: ref(false)
    }
  },
  name: "ViewPageUser",
  mixins: [accountMixin],
  data() {
    return {
      UserId: this.$route.params.id,
      user: {
        name: "",
        dataNascimento:"",
        socialName: "",
        genderIdentity: "",
        genderIdentityOthers: "",
        rg: "",
        issuingBody: "",
        uf: "",
        education: "",
        profession: "",
        profissionOthers: "",
        isDeficiency: false,
        deficiency: "",
        deficiencyOthers: "",
        deficiencyStructure: "",
        type_admin: "",
        is_admin: false,
        is_active: false,
        erroValidacao: "",
        secretary: {
          value: null,
          label: null,
        },
        service: {
          value: null,
          label: null,
        },
      },
      contact: {
        email: "",
        phone: "",
        cell_phone: "",
        institutional_phone: "",
        institutional_email: "",
        cell_phone_whatsapp: [],
        error: false,
        checkZip: "1"
      },
      personal: [],
      professional: {
        regional: "",
        lotacao: "",
        creasRegional: "",
        outrosPublicos: "",
        outrosPublicosOutro: "",
        parceirosInscInterna: "",
        funcaoOutro: "",
        municipio: "",
        superintendencia: "",
        diretoriaRegionalDesSocial: "",
        protecaoSocialBasica: "",
        protecaoSocialEspecialEstadual: "",
        vigilanciaCapacitacao: "",
        vinculoEmpregaticio: "",
        vinculoEmpregaticioOutro: "",
        funcao: "",
        orgao: "",
        areadeAtuacao: "",
        beneficiosMunicipal: "",
        beneficiosMunicipalOutro: "",
        protecaoSocialEspecialMunicipal: "",
        servicosPrograma: "",
        servicosProgramaOutro: "",
        representante: "",
        areaRepresentada: "",
        areaRepresentadaOutro: "",
        cargo: "",
        possuiRepresentacao: false,
        representacaoConselho: "",
        representacaoTitularidade: "",
        representacaoRepresentacao: "",
        representacaoSegmento: "",
        representacaoAreaRepresentada: "",
        outrosRepresentacaoAreaRepresentada: "",
        seguimento_governo: "",
      },
      address: {
        zip_code: null,
        street: null,
        number: null,
        complement: null,
        neighborhood: null,
        city: null,
        state: null,
      },
      stateFiltered: [],
      stateList: [
        "AC",
        "AL",
        "AP",
        "AM",
        "BA",
        "CE",
        "DF",
        "ES",
        "GO",
        "MA",
        "MT",
        "MS",
        "MG",
        "PA",
        "PB",
        "PR",
        "PE",
        "PI",
        "RJ",
        "RN",
        "RS",
        "RO",
        "RR",
        "SC",
        "SP",
        "SE",
        "TO",
      ],
      baseUrlViaCep: "https://viacep.com.br/ws/",
      userPerfilStatus: [
        {value: 1, label: 'ATIVO', color: 'green'},
        {value: 2, label: 'INATIVO', color: 'gray'},
        {value: 3, label: 'PENDENTE', color: 'orange'},
        {value: 4, label: 'REJEITADO', color: 'red'},
      ],
      tipoPerfilOptions: [
        {value:1, label: 'Responsavel Técnico'},
        {value:2, label: 'Participante'},
        {value:3, label: 'Colaborador'},
      ],
      genderIdentityList: [
        "Homem (cis ou trans)",
        "Mulher (cis ou trans)",
        "Não binário",
        "Outros",
      ],
      educationList: [
        "Ensino Fundamental Completo",
        "Ensino Fundamental Incompleto",
        "Ensino Médio Completo",
        "Ensino Médio Incompleto",
        "Superior Completo",
        "Superio Incompleto",
        "Pós-Graduação Lato-Sensu Completa",
        "Pós-Graduação Lato-Sensu Incompleta",
        "Mestrado Completo",
        "Mestrado Incompleto",
        "Doutorado Completo",
        "Doutorado Incompleto",
        "Curso Técnico",
      ],
      educationFiltered: [],
      professionList: [
        "Assistente Social",
        "Psicólogo",
        "Advogado",
        "Administrador",
        "Antropólogo",
        "Economista",
        "Empregada Doméstico",
        "Pedagogo",
        "Sociólogo",
        "Terapeuta",
        "Terapeuta Ocupacional",
        "Musicoterapeuta",
        "Contador",
        "Estudante",
        "Sem formação Profissional",
        "Outros",
      ],
      professionFiltered: [],
      isDeficiency: false,
      isDeficiencyStructure: false,
      deficiencyList: [
        "Auditiva",
        "Física",
        "Intelectual",
        "Transtorno do Espectro;",
        "Mental",
        "Visual",
        "Multipla",
        "Autista",
        "Outros",
      ],
      deficiencyFiltered: [],
      checkSocialName: false,
      ufFiltered: [],
      allSecretaries: [],
      filterSecretaries: [],
      services: [
        { label: "Estado", value: '1' },
        { label: "Municipio", value: '2' },
      ],
      parceirosInscInternaList: [],
      regionalList: [
          {value: 1, label: "Estadual"},
          {value: 2, label: "Municipal"},
      ],
      /* ESTADUAL */
      creasRegionalList: [
        "CREAS Regional Alto Jequitinhonha",
        "CREAS Regional Médio/Baixo Jequitinhonha",
        "CREAS Regional Mucuri",
        "CREAS Regional Vale do Rio Doce",
      ],
      outrosPublicosList: [
        "Minitério Público",
        "Direitos Humanos",
        "Defesa Civil",
        "Saúde",
        "Educação",
        "Esportes",
        "Trabalho e Emprego",
        "Outros",
      ],
      filterMunicipios: [],
      filterLotacao: [],
      superintendenciaList: [
        "Superintendência de Proteção Social Básica",
        "Superintendência de Proteção Social Especial",
        "Superintendência de Vigilância e Capacitação",
        "Assessoria de gestão do Fundo Estadual de Assistência Social",
        "Gabinete",
      ],
      protecaoSocialBasicaList: [
        "Diretoria de Serviços e Benefícios Socioassistenciais",
        "Diretoria de Gestão do Cadastro Único e Programas Socioassistenciais",
        "Não se aplica",
      ],
      protecaoSocialEspecialEstadualList: [
        "Diretoria de Proteção Social Especial de Média Complexidade",
        "Diretoria de Proteção Social Especial de Alta Complexidade",
        "Não se aplica",
      ],
      vigilanciaCapacitacaoList: [
        "Diretoria de Vigilância Socioassistencial",
        "Diretoria de Educação Permanente do SUAS",
        "Diretoria de Gestão Descentralizada e Regulação do SUAS",
        "Não se aplica",
      ],
      vinculoEmpregaticioList: [
        "Comissionado",
        "Contratado",
        "Efetivo",
        "Estatutário",
        "Estagiário",
        "Temporário",
        "Outro",
      ],
      funcaoList: [
        "Profissional de Nível Superior",
        "Profissional de Nível Médio",
        "Superintendente",
        "Diretor(a)",
        "Estagiário",
        "Auxiliar/Assessor",
        "Coordenação",
        "Outro",
      ],
      funcaoDesempenhadaList: [
        "Profissional de Nível Superior",
        "Profissional de Nível Médio",
        "Gestor de assistência social",
        "Coordenador",
        "Estagiário",
        "Assessor(a)",
      ],
      funcaoDesempenhadaCeasList: [
        "Conselheiro",
        "Secretaria Executiva",
      ],
      diretoriaRegionalDesSocialList: [
        "Almenara",
        "Araçuaí",
        "Curvelo",
        "Diamantina",
        "Divinópolis",
        "Governador Valadares",
        "Ituiutaba",
        "Juiz de Fora",
        "Metropolitana",
        "Montes Claros",
        "Muriaé",
        "Paracatu",
        "Passos",
        "Patos de Minas",
        "Poços de Caldas",
        "Salinas",
        "São João Del Rei",
        "Teófilo Otoni",
        "Timóteo",
        "Uberaba",
        "Uberlândia",
        "Varginha",
      ],
      funcaoDesempenhadaConselheiroList: [
        'Titular',
        'Suplente',
        'Vice Presidente',
        'Presidente',
      ],
      funcaoDesempenhadaSecratariaList: [
        'Governamental',
        'Sociedade Civil',
      ],
      seguimentoGovernoList: [
        'Assistência Social',
        'Saúde',
        'Educação',
        'Trabalho e Emprego',
        'Fazenda',
        'Habitação',
        'Planejamento',
        'Assessoria/Gabinete da Prefeitura',
        'Outro',
      ],
      sociedadeCivilList: [
        'Usuário',
        'Trabalhador',
        'Entidade',
      ],
      /* MUNICIPAL */
      orgaoList: [
        "Secretaria Municipal de Assistência Social",
        "Conselho Municipal de Assistência Social",
        "Entidades e Organizações de Assistência Social",
        "Outras secretarias/orgãos da Prefeitura",
        "Conselho Tutelar"
      ],
      areadeAtuacaoList1: [
        "Proteção Social Básica",
        "Proteção Social Especial",
        "Gestão do SUAS",
        "Gestão Financeira e Orçamentária do SUAS",
      ],
      areadeAtuacaoList2: [
        "Atendimento",
        "Assessoramento",
        "Defesa e garantia de direitos",
      ],
      protecaoSocialList: [
        "Serviço de Proteção e Atendimento Integral à Família (PAIF)",
        "Serviço de Convivência e Fortalecimento de Vínculos (SCFV)",
        "Serviço de Proteção Social Básica no Domicílio para pessoas com deficiência e idosas",
        "Gestão de Benefícios Socioassistenciais/Cad. Único",
      ],
      beneficioslList: [
        "Programa Bolsa Família e/ou outra ação de transferência de renda",
        "Benefício de Prestação Continuada (BPC)",
        "Benefício Eventuais",
        "Outro",
      ],
      protecaoSocialEspecialMunicipalList: [
        "Média Complexidade",
        "Alta Complexidade",
      ],
      socialEspecialMediaComplexidadeList: [
        "Serviço de Proteção e Atendimento Especializado a Famílias e Indivíduos (PAEFI)",
        "Serviço Especializado em Abordagem Social",
        "Serviço de Proteção Social a adolescentes em cumprimentos de medida socioeducativa de Liberdade Assistida (LA) e Prestação a Serviços à Comunidade (PSC)",
        "Serviço de Proteção Social Especial para Pessoas com Deficiência, Idosas e suas Famílias",
        "Serviço Especializado para Pessoas em Situação de Rua",
      ],
      socialEspecialAltaComplexidadeList: [
        "Serviço de Acolhimento Institucional",
        "Serviço de Acolhimento em República",
        "Serviço de Acolhimento em Família Acolhedora",
        "Serviço de proteção em situações de calamidades públicas e de emergências",
      ],
      gestaoDoSuasList: [
        "Vigilância Socioassistencial(Monitoramento)",
        "Gestão do Trabalho/Educação Permanente do SUAS",
        "Regulação do SUAS",
        "Outro",
      ],
      gestaoFinanceiraOrcamentariaSuasList: [
        "Gestão Financeira e Orçamentária(FMAS)",
        "Outro",
      ],
      conselheiroList: [
        "Representação",
        "Área Representada",
        "Cargo",
      ],
      representanteList: [
        "Governamental",
        "Sociedade Civil",
      ],
      representacaoGovernamentalConselheiroList: [
        "Representante Governamental",
      ],
      areaRepresentadaGovernamentalList: [
        "Assistência Social",
        "Saúde",
        "Educação",
        "Trabalho e Emprego",
        "Fazenda",
        "Habitação",
        "Planejamento",
        "Assessoria/Gabinete da Prefeitura",
        "Outro",
      ],
      areaRepresentadaCivilList: [
        "Usuários de Assistencia Social",
        "Trabalhadores de Assistencia Social",
        "Entidades de Assistencia Social",
      ],
      cargoList: [
        "Titular",
        "Suplente",
        "Presidente",
        "Vice-Presidente",
        //{value: 5, label: "Membro"},
      ],
      representacaoConselhoCMASList: [
        "Conselho Estadual de Assistência Social (CEAS)",
        "Conselho Municipal de Assistência Social (CMAS)",
      ],
      representacaoConselhoList: [
      "Conselho Estadual de Assistência Social (CEAS)",
      ],
      representacaoTitularidadeList: [
        "Titular",
        "Suplente",
        "Presidente",
        "Vice-Presidente",
      ],
      representacaoRepresentacaoList: [
      "Representante Governamental",
        "CMAS Governamental",
      ],
      representacaoSegmentoList: [
      "Usuários de Assistencia Social",
        "Trabalhadores de Assistencia Social",
        "Entidades de Assistencia Social",
        "CMAS Sociedade Civil",
      ],
      representacaoAreaRepresentadaList: [
        "Assistência Social",
        "Saúde",
        "Educação",
        "Trabalho e Emprego",
        "Fazenda",
        "Habitação",
        "Planejamento",
        "Outros",
      ],
      chipTextColor: null,
      chipLabel: null,
      chipColor: null,
      professionalData: [],
    };
  },
  methods: {
    async getUserData() {
      this.$q.loading.show({
        message: 'Carregando informações do usuário',
        backgroundColor: 'indigo',
      });
      try {
        const { data, status } = await this.apiUser(this.UserId, 'users');
        if (data) {
          this.user = data;
          this.user.servico = 'Municipal';
          if (data.service == 1) {
            this.user.servico = 'Estadual';
          }
          this.getSecretary(data.secretary);
          this.getUserPersonal();
          this.getUserContact();
          this.getUserAddress();
          this.getUserProfessionals();

          this.updateChipProperties(this.user.status_id);
          this.$q.loading.hide();
        }
        if (status !== 200) {
          this.$q.notify({
            message: 'Nao Encontrado',
            color: "negative",
            position: "top",
          });
        }
      } catch (error) {
        this.$q.loading.hide();
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
      this.$q.loading.hide();
    },
    updateChipProperties(status) {
      const perfilStatus = this.userPerfilStatus.find(item => item.value === status);
      if (perfilStatus) {
        this.chipTextColor = 'white';
        this.chipLabel = perfilStatus.label;
        this.chipColor = perfilStatus.color;
      }
    },
    async getUserPersonal() {
      try {
        const { data, status } = await this.apiUser(this.UserId, 'personal');
        if (data) { this.personal = data; }
        if (status !== 200) { console.warn('Error personal'); }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getUserContact() {
      try {
        const { data, status } = await this.apiUser(this.UserId, 'contact');
        if (data) { this.contact = data; }
        if (status !== 200) { console.warn('Error contact'); }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getUserAddress() {
      try {
        const { data, status } = await this.apiUser(this.UserId, 'address');
        if (data) { this.address = data; }
        if (status !== 200) { console.warn('Error address'); }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getUserProfessionals() {
      try {
        const { data, status } = await this.apiUser(this.UserId, 'professionals');
        if (data) { 
          this.professional = data;
          this.professionalData = data;
        }
        if (status !== 200) { console.warn('Error professional'); }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getSecretary(id) {
      try {
        const { data, status } = await this.apiGlobal(`ambitoatuacao/show/${id}`);
        if (data) { this.user.secretaria = data.nome; }
        if (status !== 200) { console.warn('Error secretaria'); }
      } catch (error) {
        this.$q.notify({
          message: error.response.data.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getAddressByZipCode() {
      try {
        this.$q.loading.show({
          message: 'Buscando endereço',
          backgroundColor: 'indigo',
        });
        const { data, status } = await axios.get(`${this.baseUrlViaCep}${this.addressData.zip_code}/json/`);
        if (status === 200) {
          this.addressData.street = data.logradouro;
          this.addressData.neighborhood = data.bairro;
          this.addressData.complement = data.complemento;
          this.addressData.city = data.localidade;
          this.addressData.state = data.uf;
          this.$refs.number.focus();
          this.$q.loading.hide();
        }
      } catch (error) {
        this.$q.loading.hide();
        return error;
      }
    },
    async getSecretaries() {
      try {
        const { data, status } = await this.$http.get(
          `ambitoatuacao/regiaoadm/${this.user?.service === 1 ? "1" : "2"}`
        );
        if (status === 200) {
          this.allSecretaries = data.map((ele) => {
            return {
              ...ele,
              label: ele.nome,
              value: ele.id,
            };
          });
          this.filterSecretaries = this.allSecretaries;
        }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getMunicipios() {
      try {
        const {data, status} = await this.$http.get(`ambitoatuacao/regiaoadm/2`);
        if (status === 200) {
          this.allMunicipios = data.map((ele) => {
            return {
              ...ele,
              label: ele.nome,
              value: ele.id,
            };
          });
          this.filterMunicipios = this.allMunicipios;
        }
      } catch (error) {
        return error;
      }
    },
    async getLotacao() {
      try {
        const {data, status} = await this.$http.get(`ambitoatuacao/regiaoadm/1`);
        if (status === 200) {
          this.allLotacao = data.map((ele) => {
            return {
              ...ele,
              label: ele.nome,
              value: ele.id,
            };
          });
          this.filterLotacao = this.allLotacao;
        }
      } catch (error) {
        return error;
      }
    },
    async salvarDadosEndereco() {
      try {
        const result = await this.$http.post('address/updatebyuser', this.address);
        if (result.status === 200) {
          this.$q.notify({
            message: 'Novo colaborador criado com sucesso!',
            color: "positive",
            position: "top",
          });
        }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async salvarDadosContato() {
      try {
        const result = await this.$http.post('contact/updatebyuser', this.contact);
        if (result.status === 200) {
          this.$q.notify({
            message: 'Novo colaborador criado com sucesso!',
            color: "positive",
            position: "top",
          });
        }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async salvarDadosPessoais() {
      let params = {
        'name': this.user.name,
        'birthday': this.user.birthday,
        'personal': this.personal
      };
  
      try {
        const result =  await this.$http.post('personal/updatebyuser', params);
        if (result.status === 200) {
          this.$q.notify({
            message: 'Novo colaborador criado com sucesso!',
            color: "positive",
            position: "top",
          });
        }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async salvarDadosProfissionais() {
      let params = {
        'user_id': this.UserId,
        'profession': this.professionalData
      }
      try {
        const result =  await this.$http.post('professionals/updatebyuser', params);
        if (result.status === 200) {
          this.$q.notify({
            message: 'Novo colaborador criado com sucesso!',
            color: "positive",
            position: "top",
          });
        }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async resetarSenhaUsuario() {
      try {
        const swalResult = await Swal.fire({
          title: "Aviso",
          html:`Uma nova senha aleatória será gerada e enviada ao email do usuário. Deseja prosseguir com o <span class="text-grey">reset?</span>`,
          // text: `Uma nova senha aleatória será gerada e enviada ao email do usuário. Deseja prosseguir com o reset?`,
          icon: "warning",
          showDenyButton: true,
          confirmButtonColor: "#5cb768",
          denyButtonColor: "#f34d45",
          confirmButtonText: "Confirmar",
          denyButtonText: 'Cancelar'
        });

        if (swalResult.isConfirmed) {
          const result = await this.$http.get(`users/reset-password/${this.UserId}`);
          if (result.status === 200) {
            this.$q.notify({
              message: 'Sucesso ao resetar a senha do usuário',
              color: "positive",
              position: "top",
            });
          }
        } else if (swalResult.isDenied) {
          this.$router.go();
        }
      } catch (error) {
        this.$q.notify({
          message: error.message || 'Falha ao cadastrar novo colaborador',
          color: "negative",
          position: "top",
        });
      }
    },
    async changeStatusUsuario(target) {
      try {
        this.$q.loading.show({
          message: 'Atualizando Usuário',
          backgroundColor: 'indigo',
        });
        let params = {
          'user_id': this.UserId,
          'status': target.value
        }
        const result = await this.$http.post('users/change-status', params);
        if (result.status === 200) {
          this.$q.notify({
            message: 'Usuário Atualizado com sucesso',
            color: "positive",
            position: "top",
          });
        }
        this.$q.loading.hide();
        // atualizando a página
        this.$router.go();
      } catch (error) {
        this.$q.notify({
          message: error.message || 'Falha ao cadastrar novo colaborador',
          color: "negative",
          position: "top",
        });
        this.$q.loading.hide();
        // atualizando a página
        this.$router.go();
      }
    },
    async changeTipoPerfilUsuario(target) {
      try {
        this.$q.loading.show({
          message: 'Atualizando Usuário',
          backgroundColor: 'indigo',
        });
        let params = {
          'user_id': this.UserId,
          'perfil': target.value
        }
        const result = await this.$http.post('users/change-perfil', params);
        if (result.status === 200) {
          this.$q.notify({
            message: 'Usuário Atualizado com sucesso',
            color: "positive",
            position: "top",
          });
        }
        this.$q.loading.hide();
        // atualizando a página
        this.$router.go();
      } catch (error) {
        this.$q.notify({
          message: error.message || 'Falha ao cadastrar novo colaborador',
          color: "negative",
          position: "top",
        });
        this.$q.loading.hide();
        // atualizando a página
        this.$router.go();
      }
    },
    voltarPagina() {
      // limpando os dados do usuario
      // para garantir que não haja cache
      this.user = [];
      // voltando a pagina de parceiros
      this.$router.push({ name: "Users" });
    },
    isRequired(value) {
      return !!value || "Campo obrigatório";
    },
    isNumber(value) {
      return ( (value && /^\d+$/.test(value)) || "Somente números" );
    },
    filterFn(val, update) {
      if (val === "") {
        update(() => { 
          this.filterSecretaries = this.allSecretaries;
        });
        return;
      }
      update(() => {
        const needle = val.toLowerCase();
        this.filterSecretaries = this.allSecretaries.filter((v) => {
          return v.nome.toLowerCase().indexOf(needle) > -1;
        });
      });
    },
    onStateFilter(val, update) {
      if (val === "") {
        update(() => {
          this.stateFiltered = this.stateList;
        });
      }
      update(() => {
        const needle = val.toLowerCase();
        this.stateFiltered = this.stateList.filter((v) =>
        v.toLowerCase().includes(needle)
        );
      });
    },
    onProfessionFilter(val, update) {
      if (val === "") {
        update(() => {this.professionFiltered = this.professionList;});
      }
      update(() => {
        const needle = this.parseStringFilter(val);
        this.professionFiltered = this.professionList.filter((v) =>
          this.parseStringFilter(v).includes(needle));
      });
    },
    isCellPhoneNumber(value) {
      return ((value && /^\(\d{2}\) \d \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres");
    },
    isPhoneNumber(value) {
      return ((value && /^\(\d{2}\) \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres");
    },
    notLessThanNormal(value) {
      return ((value && value.length <= 14) || "Máximo de 14 caracteres");
    },
    notLessThan(value) {
      return ((value && value.length <= 17) || "Máximo de 17 caracteres");
    },
    notMoreThan(value) {
      return ((value && value.length >= 11) || "Mínimo de 11 caracteres");
    },
    notMoreThanNormal(value) {
      return ((value && value.length >= 14) || "Mínimo de 14 caracteres");
    },
    isEmail(value) {
      return ((value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido");
    },
  },  
  created() {
    this.getUserData();
    this.getMunicipios();
    this.getLotacao();
  },
  watch: {
    "professional": {
      handler() {
        this.getSecretaries()
      },
      deep: true,
    },
    form: {
      handler() {
        this.$emit("address", this.address);
        this.$emit("contact", this.contact);
      },
      deep: true,
    },
  },
}
</script>
<style lang="sass" scoped>
  .my-card
      width: 100%
  .column > div
      padding: 10px 15px
      background: rgba(86, 61, 124, .15)
      border: 1px solid rgba(86, 61, 124, .2)
  .column + .column
      margin-top: 1rem
</style>