<template>
  <div class="message" v-show="message">
    {{ message }}
  </div><!-- .message -->
</template>

<script>
import { mapState } from 'vuex'

export default {
  computed: {
    ...mapState({
      message: state => state.message.content
    })
  }
}
</script>
