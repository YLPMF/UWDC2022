<template>
  <div class="navbar-container d-flex content align-items-center">

    <!-- Nav Menu Toggler -->
    <ul class="nav navbar-nav d-xl-none">
      <li class="nav-item">
        <b-link
          class="nav-link"
          @click="toggleVerticalMenuActive"
        >
          <feather-icon
            icon="MenuIcon"
            size="21"
          />
        </b-link>
      </li>
    </ul>

    <!-- Left Col -->
    <div class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex">
      <dark-Toggler class="d-none d-lg-block" />
    </div>

    <b-navbar-nav class="nav align-items-center ml-auto">
      <b-nav-item
        right
      >
        <div class="d-table-row d-none user-nav">
          <p class="user-name font-weight-bolder mb-0">
            John Doe
          </p>
          <span class="user-status">Admin</span>
        </div>
      </b-nav-item>
      <b-nav-item
        right
        class="ml-1"
      >
        <b-button variant="outline-primary">
          Sign out
        </b-button>
      </b-nav-item>
    </b-navbar-nav>
  </div>
</template>

<script>
import {
  BLink, BNavbarNav, BButton,
} from 'bootstrap-vue'
import DarkToggler from '@core/layouts/components/app-navbar/components/DarkToggler.vue'

export default {
  components: {
    BLink,
    BNavbarNav,
    BButton,
    // Navbar Components
    DarkToggler,
  },
  props: {
    toggleVerticalMenuActive: {
      type: Function,
      default: () => {},
    },
  },
}
</script>
