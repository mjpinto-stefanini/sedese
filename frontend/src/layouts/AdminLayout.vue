<template>
    <q-layout view="lHh Lpr lFf">
        <q-header>
            <q-toolbar>
                <q-btn flat dense round @click="leftDrawerOpen = !leftDrawerOpen" aria-label="Menu" icon="menu" />
                <q-toolbar-title> {{ appTitle }} </q-toolbar-title>
                <q-btn icon="person" flat round>
                <q-menu>
                    <q-list style="min-width: 100px">
                        <q-item clickable v-close-popup to="signin">
                            <q-item-section side>
                                <q-icon name="mdi-exit-to-app" color="negative"/>
                            </q-item-section>
                            <q-item-section>Logout</q-item-section>
                        </q-item>
                    </q-list>
                </q-menu>
                </q-btn>
            </q-toolbar>
        </q-header>
        <q-drawer v-model="leftDrawerOpen" show-if-above bordered class="bg-grey-2">
            <q-list>
                <q-item-label header>Menu - Lateral</q-item-label>
                <q-separator />
                <q-item clickable to="/users">
                    <q-item-section avatar>
                        <q-icon name="home" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label>Home - Admin</q-item-label>
                    </q-item-section>
                </q-item>
                <q-expansion-item
                  expand-separator
                  icon="event_note"
                  label="Ações de Apoio Técnico"
                >
                    <q-card>
                        <q-card-section>
                            <q-item clickable to="/createaction">
                                <q-item-section avatar>
                                    <q-icon name="code" />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>Criar nova ação</q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-separator />
                            <q-item clickable to="/acoes">
                                <q-item-section avatar>
                                    <q-icon name="code" />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>Listar Ações</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-card-section>
                    </q-card>
                </q-expansion-item>
                <q-expansion-item
                expand-separator
                  icon="event_note"
                  label="Gerencias Parceiros">
                  <q-card>
                    <q-card-section>
                      <!-- <q-item clickable to="/users">
                        <q-item-section avatar>
                          <q-icon name="code" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Gerenciar Usuários</q-item-label>
                        </q-item-section>
                      </q-item> -->
                      <q-separator/>
                      <q-item clickable to="/listaparceiros">
                        <q-item-section avatar>
                          <q-icon name="code" />
                        </q-item-section>
                        <q-item-section>
                          <q-item-label>Gerenciar Parceiros</q-item-label>
                        </q-item-section>
                      </q-item>
                    </q-card-section>
                  </q-card>
                </q-expansion-item>
                <!--
                <q-expansion-item
                  expand-separator
                  icon="groups"
                  label="Turma"
                >
                    <q-card>
                        <q-card-section>
                            <q-item clickable to="createclass">
                                <q-item-section avatar>
                                    <q-icon name="code" />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>Criar nova turma</q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-separator />
                            <q-item clickable to="/turmas">
                                <q-item-section avatar>
                                    <q-icon name="code" />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>Listar turmas</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-card-section>
                    </q-card>
                </q-expansion-item>
                <q-separator />
                -->
            </q-list>
        </q-drawer>
        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<script>
    export default {
        name: "AdminLayout",
        data() {
            return {
                leftDrawerOpen: false,
            };
        },
    };
</script>
