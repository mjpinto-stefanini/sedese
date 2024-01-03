<template>
  <q-layout view="lHh Lpr lFf">
    <q-header>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
          icon="menu"
        />
        <q-toolbar-title> {{ appTitle }} </q-toolbar-title>
        <q-btn icon="person" flat round>
          <q-menu>
            <q-list style="min-width: 100px">
              <q-item clickable v-close-popup to="signin">
                <q-item-section side
                  ><q-icon name="mdi-exit-to-app" color="negative"
                /></q-item-section>
                <q-item-section>Logout</q-item-section>
              </q-item>
            </q-list>
          </q-menu>
        </q-btn>
      </q-toolbar>
    </q-header>
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>
<script>
export default {
  name: "UserLayout",
  data() {
    return {
      leftDrawerOpen: false,
    };
  },
};
</script>
