<template>
  <div class="photo">
    <figure class="photo__wrapper">
      <img class="photo__image" :src="item.url" :alt="`Photo by ${item.owner.name}`">
    </figure><!-- .photo__wrapper -->
    <RouterLink class="photo__overlay" :to="`/photos/${item.id}`" :title="`View the photo by ${item.owner.name}`">
      <div class="photo__controls">
        <button class="photo__action photo__action--like" title="Like photo">
          <i class="icon icon-md-heart"></i><!-- .icon icon-md-heart -->
          12
        </button><!-- .photo__action photo__action--like -->
        <a class="photo__action" title="Download photo" @click.stop :href="`/photos/${item.id}/download`">
          <i class="icon icon-md-arrow-round-down"></i><!-- .icon icon-md-arrow-round-down -->
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
  }
}
</script>
