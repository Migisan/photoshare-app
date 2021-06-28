<template>
  <div v-if="photo" class="photo-detail" :class="{ 'photo-detail--column': fullWidth }">
    <figure class="photo-detail__pane photo-detail__image" @click="fullWidth = !fullWidth">
      <img :src="photo.url" alt="">
      <figcaption>Posted by {{ photo.owner.name }}</figcaption>
    </figure><!-- .photo-detail__pane photo-detail__image -->
    <div class="photo-detail__pane">
      <button class="button button--like" title="Like photo">
        <i class="icon icon-md-heart"></i><!-- .icon icon-md-heart -->
        12
      </button><!-- .button button--like -->
      <a :href="`/photos/${photo.id}/download`" class="button" title="Download photo">
        <i class="icon icon-md-arrow-round-down"></i><!-- .icon icon-md-arrow-round-down -->
        Download
      </a><!-- .button -->
      <h2 class="photo-detail__title">
        <i class="icon icon-md-chatboxes"></i><!-- .icon icon-md-chatboxes -->
        Comments
      </h2><!-- .photo-detail__title -->
    </div><!-- .photo-detail__pane -->
  </div><!-- .photo-detail -->
</template>

<script>
import { OK } from '../util'

export default {
  props: {
    id: {
      type: String,
      required: true,
    }
  },
  data() {
    return {
      photo: null,
      fullWidth: false
    }
  },
  methods: {
    async fetchPhoto() {
      const response = await axios.get(`/api/photos/${this.id}`)

      if(response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.photo = response.data
    }
  },
  watch: {
    '$route': {
      async handler() {
        await this.fetchPhoto()
      },
      immediate: true,
    }
  }
}
</script>


