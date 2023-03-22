<template>
	<q-page padding>
		<q-dialog v-model="dialog" persistent>
			<q-card>
				<q-card-section class="row items-center">
					<q-toolbar>
						<q-avatar icon="person" color="primary" text-color="white" />
						<q-toolbar-title>{{ selectedUser.name }} </q-toolbar-title>
						<span class="q-ml-sm"> {{ selectedUser.created }} </span>
						<q-btn
							color="primary"
							icon="close"
							round
							flat
							@click="dialog = false"
							class="q-ml-md"
						/>
					</q-toolbar>
				</q-card-section>

				<q-separator class="q-mb-lg" />

				<q-card flat>
					<q-card-section>
						<div class="row q-col-gutter-md">
							<div class="col-12">
								<q-toggle
									v-model="form.is_active"
									color="green"
									label="Ativado"
									:disable="user.is_admin && user.type_admin === '3'"
								/>
							</div>

							<div class="col-12">
								<q-toggle
									v-model="form.is_admin"
									color="green"
									label="Administrador"
									:disable="user.is_admin && user.type_admin !== '1'"
								/>
							</div>

							<div class="col-12">
								<q-select
									:disable="
										user.is_admin &&
										user.type_admin !== '1' &&
										user.type_admin !== '2'
									"
									v-model="form.type_admin"
									:options="optionsUser"
									label="Tipo de Administrador"
									outlined
									use-input
									clear-icon="close"
									clearable
								/>
							</div>
						</div>
					</q-card-section>
				</q-card>

				<!-- {{ selectedUser }} -->

				<q-card-actions align="right">
					<q-btn
						color="negative"
						label="Resetar Senha"
						no-caps
						unelevated
						padding="sm xl"
						@click="dialog = true"
						v-close-popup
					/>
					<q-btn
						color="primary"
						label="Salvar"
						no-caps
						unelevated
						padding="sm xl"
						@click="onSave"
					/>
				</q-card-actions>
			</q-card>
		</q-dialog>

		<q-toolbar>
			<q-toolbar-title> Lista de usuários </q-toolbar-title>
			<q-btn flat round dense icon="apps" class="q-mr-xs" />
			<q-btn flat round dense icon="more_vert" />
		</q-toolbar>
		<q-table :rows="rows" :columns="columns" row-key="name" flat bordered>
			<template v-slot:header-cell-is_active="props">
				<q-th :props="props">
					{{ props.col.label }}
					<q-icon name="sym_o_info" size="1.2rem" color="primary">
						<q-tooltip
							class="bg-primary text-caption"
							:offset="[10, 10]"
							style="max-width: 600px"
							>Informa se o usuario está ativo na plataforma, se desabilitar o
							usuario não poderá acessar a plataforma.
						</q-tooltip>
					</q-icon>
				</q-th>
			</template>

			<template v-slot:body-cell-id="props">
				<q-td :props="props">
					<div class="q-gutter-sm">
						<q-btn
							color="primary"
							label="Editar"
							no-caps
							unelevated
							padding="sm xl"
							@click="openModal(props)"
						/>
					</div>
				</q-td>
			</template>
			<template v-slot:body-cell-service="props">
				<q-td :props="props">
					<q-chip
						:label="props.row.service"
						:color="props.row.service === 'Estadual' ? 'green' : 'blue'"
						text-color="white"
					/>
				</q-td>
			</template>
			<template v-slot:body-cell-type_admin="props">
				<q-td :props="props">
					<q-chip
						:text-color="props.row.type_admin === 'Usuário' ? 'black' : 'white'"
						:label="props.row.type_admin"
						:color="
							props.row.type_admin === 'Administrador'
								? 'red'
								: props.row.type_admin === 'Operador'
								? 'orange'
								: 'gray'
						"
					/>
				</q-td>
			</template>
			<template v-slot:body-cell-is_admin="props">
				<q-td :props="props">
					<div class="q-gutter-sm">
						<q-icon name="print" />
						<!-- <q-toggle v-model="props.row.is_admin">
										<q-icon name="sym_o_info" size="1.2rem" color="primary">
												<q-tooltip
														class="bg-primary text-caption"
														:offset="[10, 10]"
														style="max-width: 600px">Administrativo: Informa se o usuario é um administrador.
												</q-tooltip>
										</q-icon>
								</q-toggle> -->
					</div>
				</q-td>
			</template>
			<template v-slot:body-cell-is_active="props">
				<q-td :props="props">
					<div class="q-gutter-sm">
						<q-chip
							:text-color="props.row.is_active ? 'white' : 'dark'"
							:label="props.row.is_active ? 'Ativado' : 'Desativado'"
							:color="props.row.is_active ? 'green' : 'gray'"
						/>
					</div>
				</q-td>
			</template>
		</q-table>
	</q-page>
</template>

<script>
export default {
	name: "UsersPage",
	data() {
		return {
			dialog: false,
			user: {},
			form: {
				type_admin: "",
				is_admin: false,
				is_active: false,
			},
			optionsUser: [
				{ label: "Diretor", value: "1" },
				{ label: "Operador", value: "2" },
				{ label: "Usuário", value: "3" },
			],
			columns: [
				{
					name: "is_active",
					label: "Ativo",
					field: "is_active",
					align: "center",
					sortable: true,
				},
				{
					name: "name",
					label: "Nome",
					field: "name",
					align: "left",
					sortable: true,
				},
				{
					name: "service",
					label: "Ambito de atuação",
					field: "service",
					align: "left",
					sortable: true,
				},
				{
					name: "secretary",
					label: "Secretaria",
					field: "secretary",
					align: "left",
					sortable: true,
				},
				{
					name: "id",
					label: "Ações",
					field: "id",
					align: "center",
					sortable: true,
				},
			],
			rows: [],
			selectedUser: {},
		};
	},
	methods: {
		async onSave() {
			console.log("salvar");
			console.log(this.form.type_admin);
			const data = {
				is_active: this.form.is_active,
				is_admin: this.form.is_admin,
				type_admin: this.form.type_admin.value,
			};
			try {
				console.log(data.type_admin);
				const { status } = await this.$http.patch(
					`users/${this.selectedUser.id}/`,
					data
				);
				if (status === 200) {
					this.$q.notify({
						message: "Usuário atualizado com sucesso!",
						color: "green-4",
						textColor: "white",
						icon: "check_circle",
					});
					this.rows = [];
					this.getUsers();
					this.dialog = false;
				}
			} catch (error) {
				console.log(error);
			}
		},
		openModal(props) {
			this.selectedUser = props.row;
			this.form.is_active = this.selectedUser.is_active;
			this.form.is_admin = this.selectedUser.is_admin;
			this.form.type_admin = this.selectedUser.type_admin;
			this.user = JSON.parse(localStorage.getItem("user"));
			this.dialog = true;
			console.log(this.user);
			console.log(this.selectedUser);
		},
		async getUsers() {
			try {
				const { data, status } = await this.$http.get("users/");
				if (status === 200) {
					data.forEach((user) => {
						this.rows.push({
							name: user.name,
							cpf: user.cpf.replace(
								/(\d{3})(\d{3})(\d{3})(\d{2})/,
								"$1.$2.$3-$4"
							),
							service: user.service === "1" ? "Estadual" : "Municipal",
							secretary: user.secretary,
							is_admin: !!user.is_admin,
							id: user.id,
							is_active: !!user.is_active,
							type_admin:
								user.type_admin === "1"
									? "Administrador"
									: user.type_admin === "2"
									? "Operador"
									: "Usuário",
							created: new Date(user.created_at).toLocaleString("pt-BR"),
						});
					});
					// this.rows = data;
				}
			}   catch (error) {
                this.$q.notify({
                    message: error.response.data.message,
                    color: "negative",
                    position: "top",
                });
            }
		},
	},
	created() {
		this.getUsers();
	},
};
</script>

<style></style>
