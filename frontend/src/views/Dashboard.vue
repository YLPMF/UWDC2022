<template>
  <div>
    <b-navbar
      variant="secondary"
    >
      <b-navbar-nav>
        <b-nav-item
          class="ml-1"
        >
          <b-button
            variant="outline-secondary"
            class="navbar-button"
          >
            ADD NEW
          </b-button>
        </b-nav-item>
      </b-navbar-nav>

      <b-navbar-nav class="ml-auto">
        <b-nav-item
          right
        >
          <div class="d-table-row d-none user-nav">
            <p class="user-name font-weight-bolder mb-0 ">
              John Doe
            </p>
            <span class="user-status">Admin</span>
          </div>
        </b-nav-item>
        <b-nav-item
          right
          class="ml-1"
        >
          <b-button
            variant="outline-secondary"
            class="navbar-button"
          >
            SIGN OUT
          </b-button>
        </b-nav-item>
      </b-navbar-nav>
    </b-navbar>

    <b-container
      fluid
      class="mt-1"
    >
      <b-row>
        <b-col lg="3">
          <b-card title="Logged working hours">
            <b-row no-gutters align="center">
              <b-col md="6">
                <div class="hours">
                  15,5 h
                  <span>Total</span>
                </div>
              </b-col>
              <b-col md="6">
                <div class="hours">
                  15,5 h
                  <span>Last month</span>
                </div>
              </b-col>
            </b-row>
          </b-card>
          <b-card title="12 months overview">

          </b-card>
          <b-card title="Categories">

          </b-card>
          <b-card title="Used technologies">

          </b-card>
        </b-col>
        <b-col lg="9">
          <b-table striped hover :items="items" :fields="fields"></b-table>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import {
  BCard, BCardText, BLink, BContainer, BRow, BCol, BNavbar, BButton, BNavItem, BNavbarNav, BTable,
} from 'bootstrap-vue'

export default {
  components: {
    BCard,
    BCardText,
    BLink,
    BContainer,
    BRow,
    BCol,
    BNavbar,
    BButton,
    BNavItem,
    BNavbarNav,
    BTable,
  },
  data() {
    return {
      fields: [
        {
          key: 'created_at',
          label: 'Date',
          sortable: true,
        },
        {
          key: 'type',
          label: 'Type',
          sortable: true,
        },
        {
          key: 'category',
          label: 'Category',
          sortable: true,
        },
        {
          key: 'time',
          label: 'Time',
          sortable: true,
        },
        {
          key: 'Notes',
          label: 'Notes',
        },
        {
          key: 'tags',
          label: 'Tags',
        },
        {
          key: 'actions',
          label: '',
        },
      ],
      items: [
        { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
        { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
        { age: 38, first_name: 'Jami', last_name: 'Carney' },
      ],
    }
  },
}
</script>

<style scoped lang="scss">
.d-table-row.d-none.user-nav,
button.btn.navbar-button.btn-outline-secondary {
  color: white;
  border-color: white!important;
}

.hours {
  font-size: 24px;
  display: inline-grid;
  text-align: center;
  span {
    font-size: 14px;
  }
}
</style>
