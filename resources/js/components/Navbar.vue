<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      Vuesplash
    </RouterLink>
    <div class="navbar__menu">
      <div v-if="isLogin" class="navbar__item">
        <button class="button" @click="showForm = !showForm">
          <i class="icon icon-md-add"></i>
          Submit a photo
        </button><!-- .button -->
      </div><!-- .navbar__item -->
      <span v-if="isLogin" class="navbar__item">
        {{ username }}
      </span><!-- .navbar__item -->
      <div v-else class="navbar__item">
        <RouterLink class="button button--link" to="/login">
          Login / Register
        </RouterLink>
      </div><!-- .navbar__item -->
    </div><!-- .navbar__menu -->
    <PhotoForm v-model="showForm" />
  </nav><!-- .navbar -->
</template>

<script>
import PhotoForm from './PhotoForm.vue'

export default {
  components: {
    PhotoForm
  },
  data() {
    return {
      showForm: false
    }
  },
  computed: {
    isLogin() {
      return this.$store.getters['auth/check']
    },
    username() {
      return this.$store.getters['auth/username']
    }
  }
}
</script>
