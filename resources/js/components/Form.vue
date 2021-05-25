<template>
  <div
    id="person-form"
    style="width: 80%; margin: auto;"
  >

    <div id="form-fields">

      <div class="field">
        <label class="label">Nome</label>
        <div class="control">
          <input
            class="input"
            type="text"
            placeholder="Insira o nome"
            v-model="person.name"
          >
        </div>
      </div>

      <div class="field">
        <label class="label">Sobrenome</label>
        <div class="control">
          <input
            class="input"
            type="text"
            placeholder="Insira o sobrenome"
            v-model="person.lastName"
          >
        </div>
      </div>

      <div class="field">
        <label class="label">Email</label>
        <div class="control">
          <input
            class="input"
            type="email"
            placeholder="Insira o Email"
            v-model="person.email"
          >
        </div>
      </div>

      <div class="field">
        <label class="label">Telefone</label>
        <div class="control">
          <input
            class="input"
            type="text"
            placeholder="Insira o telefone"
            v-mask="'(##)# ####-####'"
            v-model="person.phone"
          >
        </div>
      </div>

      <div class="field">
        <div class="control">
          <label class="checkbox">
            <input
              type="checkbox"
              v-model="person.isJur"
            >
            Pessoa jurídica
          </label>
        </div>
      </div>

      <div
        class="field"
        v-show="showCpf"
      >
        <label class="label">Pessoa física</label>
        <div class="control">
          <input
            class="input"
            type="text"
            placeholder="Insira o cpf"
            v-mask="'###.###.###-##'"
            v-model="person.cpf"
          >
        </div>
      </div>

      <div
        class="field"
        v-show="!showCpf"
      >
        <label class="label">Pessoa jurídica</label>
        <div class="control">
          <input
            class="input"
            type="text"
            placeholder="Insira o cnpj"
            v-mask="'	##.###.###/####-##'"
            v-model="person.cnpj"
          >
        </div>
      </div>

      <div
        class="field"
        v-show="validationErros.length > 0"
      >
        <p
          v-for="(error, index) in validationErros"
          :key="index"
          class="help is-danger"
        >
          {{error}}
        </p>
      </div>

      <div
        class="field"
        v-show="showSuccessMessage"
      >
        <p class="help is-success">
          Salvo com sucesso
        </p>
      </div>

      <div
        class="field"
        v-show="showDeletedMessage"
      >
        <p class="help is-danger">
          Registro deletado
        </p>
      </div>

      <div class="field is-grouped">
        <div class="control">
          <button
            class="button is-link"
            @click="submit"
          >Gravar</button>
        </div>
      </div>

    </div>

    <div
      id="persons-table"
      v-if="persons.length > 0"
    >
      <PersonsTable
        :list="persons"
        @editPerson="editPerson"
        @removePerson="removePerson"
      />
    </div>
  </div>
</template>

<script>
import PersonsTable from "./PersonsTable.vue"
export default {
  name: "person-form",
  mounted() {
    this.getPersons()
  },
  components: {
    PersonsTable,
  },
  computed: {
    showCpf() {
      if (this.isJur) {
        return false
      }
      return true
    },
  },
  data() {
    return {
      editIndex: -1,
      validationErros: [],
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      person: this.newPerson(),
      showSuccessMessage: false,
      showDeletedMessage: false,
      persons: [],
    }
  },
  methods: {
    removePerson(index) {
      let id = this.persons[index].id
      fetch("http://localhost:8000/api/del-person", {
        method: "DELETE",
        headers: {
          "content-type": "application/json",
        },
        body: JSON.stringify({id}),
      })
        .then((response) => {
          if (response.status == 200) {
            this.showDeletedMessage = true
            this.$delete(this.persons, index)
            setTimeout(() => {
              this.showDeletedMessage = false
            }, 6000)
          }
          response.text()
        })
        .then((result) => {
          console.log("result", result)
          this.newPerson()
        })
        .catch((err) => {
          console.log(`err`, err)
        })
    },
    editPerson(index) {
      this.person = Object.assign(this.person, this.persons[index])
      this.editIndex = index
    },
    getPersons() {
      axios.get("./api/get-persons").then((response) => {
        if (response.status == 200) {
          this.persons = response.data
        }
      })
    },
    newPerson() {
      return {
        name: "",
        lastName: "",
        email: "",
        phone: "",
        isJur: false,
        cpf: "",
        cnpj: "",
      }
    },
    isValidInput() {
      if (!this.person.name) {
        this.validationErros.push("Nome é requerido")
      }
      if (!this.person.lastName) {
        this.validationErros.push("Sobrenome é requerido")
      }
      if (!this.person.email) {
        this.validationErros.push("Email é requerido")
      } else if (this.person.email.indexOf("@") == -1) {
        this.validationErros.push("Email inválido")
      }
      if (!this.person.phone) {
        this.validationErros.push("Fone é requerido")
      }
      if (!this.person.isJur && !this.person.cpf) {
        this.validationErros.push("Cpf é requerido")
      } else if (this.person.isJur && !this.person.cnpj) {
        this.validationErros.push("Cnpj é requerido")
      }
      if (this.validationErros.length == 0) return true

      return false
    },
    submit() {
      if (this.isValidInput()) {
        if (this.editIndex == -1) {
          this.persons.push(this.person)

          fetch("http://localhost:8000/api/create-person", {
            method: "POST",
            headers: {
              "content-type": "application/json",
              "X-CSRF-TOKEN": this.csrf,
            },
            body: JSON.stringify(this.person),
          })
            .then((response) => {
              if (response.status == 201) {
                this.showSuccessMessage = true
                setTimeout(() => {
                  this.showSuccessMessage = false
                }, 6000)
              }
              response.text()
            })
            .then((result) => {
              console.log("result", result)
              this.newPerson()
            })
            .catch((err) => {
              console.log(`err`, err)
            })
        } else {
          debugger
          this.$set(this.persons, this.editIndex, this.person)
          fetch("http://localhost:8000/api/update-person", {
            method: "PUT",
            headers: {
              "content-type": "application/json",
            },
            body: JSON.stringify(this.person),
          })
            .then((response) => {
              if (response.status == 200) {
                this.showSuccessMessage = true
                setTimeout(() => {
                  this.showSuccessMessage = false
                }, 6000)
              }
              response.text()
            })
            .then((result) => {
              console.log("result", result)
              this.newPerson()
            })
            .catch((err) => {
              console.log(`err`, err)
            })
        }
      }
    },
  },
}
</script>