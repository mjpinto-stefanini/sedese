<template>
	<q-page padding>
		<q-dialog v-model="dialog" persistent>
			<q-card>

			</q-card>
		</q-dialog>

		<q-toolbar>
			<q-toolbar-title> Lista de açoes </q-toolbar-title>
			<q-btn flat round dense icon="apps" class="q-mr-xs" />
			<q-btn flat round dense icon="more_vert" />
		</q-toolbar>
		<q-table>

		</q-table>
	</q-page>
</template>

<script>
export default {
	name: "ActionsPage",
	data() {
		return {
			dialog: false,
		};
	},
	methods: {},
};
</script>

<style></style>
