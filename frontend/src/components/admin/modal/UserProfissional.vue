<template>
  <q-dialog v-model="internalShowModal">
    <q-card style="width: 80%; max-width: 80vw;">
      <q-card-section>
        <h6 style="margin:0px; padding: 0px;">Editar Dados Profissionais {{ professionalData.regional }}</h6>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
export default {
  name: "ModalUserProfissional",
  props: {
    dadosUser: {},
    showModal: Boolean
  },
  computed: {
    internalShowModal: {
      get() {
        return this.showModal;
      },
      set(value) {
        this.$emit("update:show-modal", value);
      }
    },
    professionalData() {
      return this.dadosUser.professionalData || {};
    }
  }
};
</script>