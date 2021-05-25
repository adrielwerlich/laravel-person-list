<template>
  <div
    id="persons-table"
    style="margin: 5% 2%; width: 80%;"
  >
    <table class="table">
      <thead>
        <tr>
          <th width="20%">Id</th>
          <th width="50%">Nome</th>
          <th width="30%">Email</th>
          <th width="20%">Ações</th>
        </tr>
      </thead>
      <tbody v-if="list && list.length > 0">
        <tr
          v-for="(person, index) in list"
          :key="index"
        >
          <td>#{{index}}</td>
          <td>
            {{fullName(person.name, person.lastName)}}
          </td>
          <td>{{person.email}}</td>
          <td>

            <div class="field is-grouped">
              <div class="control">
                <button
                  class="button is-link"
                  @click="edit(index, person)"
                >Editar</button>
              </div>
              <div class="control">
                <button 
                  class="button is-link is-light"
                  @click="remove(index)"
                >Delete</button>
              </div>
            </div>
          </td>

        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "perstable",
  props: {
    list: Array,
  },
  computed: {},
  data() {
    return {
      index: -1,
      firstName: "",
      lastName: "",
    }
  },
  methods: {
    fullName(name, last) {
      return name + " " + last
    },
    remove(ind) {
      this.$emit('removePerson', ind)
    },
    edit(ind) {
      this.$emit('editPerson', ind)
    },
  },
}
</script>