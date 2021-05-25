<template>
  <div id="home">
    <div class="container is-fullhd">
      <nav
        class="navbar"
        role="navigation"
        aria-label="main navigation"
      >

        <div
          id="navbarBasicExample"
          class="navbar-menu"
        >
          <div
            class="navbar-start"
            style="margin: 0 auto;"
          >
            <router-link
              class="navbar-item"
              :to="{ name: 'PersonForm'}"
            >
              Formulário de cadastro
            </router-link>

            <a class="navbar-item">
              Listagem do cadastro
            </a>

          </div>

        </div>
      </nav>

      <div id="content-display">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: "home",
  mounted() {

    // axios.get('./api/get-persons')
    //     .then(response => console.log(`response`, response));

    // fetch("http://localhost:8000/api/get-persons", {
    //   method: "GET",
    //   headers: {
    //       'content-type': 'application/json'
    //     }
    // })
    //   .then((response) => {
    //     response.
    //   })
    //   .then((result) => {
    //     console.log("result", result)
    //   })
    //   .catch((err) => {
    //     console.log(`err`, err)
    //   })
  },
}
</script>

<style lang="sass">
@import "~bulma/bulma.sass"
</style>