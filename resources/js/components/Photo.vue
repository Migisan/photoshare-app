<template>
  <div class="photo">
    <figure class="photo__wrapper">
      <img class="photo__image" :src="item.url" :alt="`Photo by ${item.owner.name}`">
    </figure><!-- .photo__wrapper -->
    <RouterLink class="photo__overlay" :to="`/photos/${item.id}`" :title="`View the photo by ${item.owner.name}`">
      <div class="photo__controls">
        <button class="photo__action photo__action--like" :class="{'photo__action--liked': item.liked_by_user}" title="Like photo" @click.prevent="like">
          <i class="fas fa-heart"></i>
          {{ item.likes_count }}
        </button><!-- .photo__action photo__action--like -->
        <a class="photo__action" title="Download photo" @click.stop :href="`/photos/${item.id}/download`">
          <i class="fas fa-arrow-down"></i>
        </a><!-- .photo__action -->
      </div><!-- .photo__controls -->
      <div class="photo__username">
        {{ item.owner.name }}
      </div><!-- .photo__username -->
    </RouterLink>
  </div><!-- .photo -->
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true,
    }
  },
  methods: {
    like() {
      this.$emit('like', {
        id: this.item.id,
        liked: this.item.liked_by_user
      })
    }
  }
}
</script>
