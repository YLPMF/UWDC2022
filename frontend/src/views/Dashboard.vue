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
            v-b-toggle.sidebar-1
            @click="edit = false; form = []"
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
              {{ user.name }}
            </p>
            <span class="user-status">Competitor</span>
          </div>
        </b-nav-item>
        <b-nav-item
          right
          class="ml-1"
        >
          <b-button
            variant="outline-secondary"
            class="navbar-button"
            @click="logout"
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
            <b-row
              no-gutters
              align="center"
            >
              <b-col md="6">
                <div class="hours" v-if="statistics.total">
                  {{ statistics.total[0].sum }} h
                  <span>Total</span>
                </div>
              </b-col>
              <b-col md="6">
                <div class="hours" v-if="statistics.last_month">
                  {{ statistics.last_month[0].sum }} h
                  <span>Last month</span>
                </div>
              </b-col>
            </b-row>
          </b-card>
          <b-card title="12 months overview" />
          <b-card title="Categories" />
          <b-card title="Used technologies" />
        </b-col>
        <b-col lg="9">
          <b-table
            striped
            hover
            :items="items"
            :fields="fields"
          >
            <template #cell(tags)="data">
              <b-badge v-for="tag in data.item.tags" variant="secondary" class="tag-badge">{{ tag.title }}</b-badge>
            </template>

            <template #cell(actions)="data">
              <b-icon-pencil @click="getEntryById(data.item.id)" v-b-toggle.sidebar-1></b-icon-pencil>
            </template>

          </b-table>
        </b-col>
      </b-row>
    </b-container>

    <b-sidebar id="sidebar-1" :title=" edit ? 'Edit an entry' : 'Add new entry'" shadow v-if="options">
      <b-form class="px-1 py-1" @submit.prevent="createEntry">
        <b-form-group
            id="input-group-1"
            label="Date *"
            label-for="input-1"
        >
          <b-form-input
              id="input-1"
              v-model="form.date"
              type="date"
              placeholder="Date"
              required
          ></b-form-input>
        </b-form-group>

        <b-form-group
            id="input-group-2"
            label="Type *"
            label-for="input-2"
        >
          <b-form-input
              id="input-2"
              list="type-list"
              v-model="form.type"
              required
          ></b-form-input>

          <datalist id="type-list">
            <option v-for="type in options.types" :id="type.id">{{ type.title }}</option>
          </datalist>
        </b-form-group>

        <b-form-group
            id="input-group-3"
            label="Category *"
            label-for="input-3"
        >
          <b-form-input
              id="input-3"
              list="category-list"
              v-model="form.category"
              required
          ></b-form-input>

          <datalist id="category-list">
            <option v-for="category in options.categories" :id="category.id">{{ category.title }}</option>
          </datalist>
        </b-form-group>

        <b-form-group
            id="input-group-4"
            label="Spent time *"
            label-for="input-4"
        >
          <b-form-input
              id="input-4"
              v-model="form.time"
              type="number"
              placeholder="Spent time"
              required
          ></b-form-input>
        </b-form-group>

        <b-form-group
            id="input-group-5"
            label="Notes"
            label-for="input-5"
        >
          <b-form-input
              id="input-4"
              v-model="form.notes"
              type="text"
              placeholder="Notes"
          ></b-form-input>
        </b-form-group>

        <b-form-group
            id="input-group-3"
            label="Tags *"
            label-for="input-3"
        >
          <b-form-tags v-model="form.tags" no-outer-focus class="mb-3 custom-form-tags">
            <template v-slot="{ tags, inputAttrs, inputHandlers, addTag, removeTag }">
              <b-input-group aria-controls="my-custom-tags-list">
                <input
                    v-bind="inputAttrs"
                    v-on="inputHandlers"
                    list="tag-list"
                    placeholder="New tag - Press enter to add"
                    class="form-control">

                <datalist id="tag-list">
                  <option v-for="tag in options.tags" :id="tag.id">{{ tag.title }}</option>
                </datalist>
                <b-input-group-append>
                  <b-button @click="addTag()" variant="primary">Add</b-button>
                </b-input-group-append>
              </b-input-group>
              <ul
                  id="my-custom-tags-list"
                  class="list-unstyled d-inline-flex flex-wrap mb-0"
                  aria-live="polite"
                  aria-atomic="false"
                  aria-relevant="additions removals"
              >
                <!-- Always use the tag value as the :key, not the index! -->
                <!-- Otherwise screen readers will not read the tag
                     additions and removals correctly -->
                <b-card
                    v-for="tag in tags"
                    :key="tag"
                    :id="`my-custom-tags-tag_${tag.replace(/\s/g, '_')}_`"
                    tag="li"
                    class="form-tag-card"
                >
                  <strong>{{ tag }}</strong>
                  <b-button
                      @click="removeTag(tag)"
                      variant="link"
                      size="sm"
                      :aria-controls="`my-custom-tags-tag_${tag.replace(/\s/g, '_')}_`"
                  ><b-icon-trash></b-icon-trash></b-button>
                </b-card>
              </ul>
            </template>
          </b-form-tags>

        </b-form-group>

        <b-button type="submit" variant="primary">Save entry</b-button>
      </b-form>
    </b-sidebar>
  </div>
</template>

<script>
import {
  BCard, BCardText, BLink, BContainer, BRow, BCol, BNavbar, BButton, BNavItem, BNavbarNav, BTable, BBadge,
  BIconPencil, BSidebar, VBToggle, BForm, BFormGroup, BFormInput, BFormDatalist, BFormTags, BInputGroup, BInputGroupAppend,
  BIconTrash
} from 'bootstrap-vue'
import {mapActions, mapGetters, mapMutations} from 'vuex';
import ToastificationContent from "@core/components/toastification/ToastificationContent";

export default {
  directives: {
    'b-toggle': VBToggle
  },
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
    BBadge,
    BSidebar,
    BIconPencil,
    BForm,
    BFormGroup,
    BFormInput,
    BFormDatalist,
    BFormTags,
    BInputGroup,
    BInputGroupAppend,
    BIconTrash
  },
  data() {
    return {
      edit: false,
      id: null,
      statistics: [],
      form: {
        date: '',
        type: '',
        category: '',
        time: '',
        notes: '',
        tags: [],
      },
      options: [],
      fields: [
        {
          key: 'date',
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
          key: 'notes',
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
  computed: {
    ...mapGetters ({
      user: "auth/user",
    })
  },
  mounted() {
    this.getEntries();
    this.getOptions();
    this.getStatistics();
  },
  methods: {
    ...mapActions ({
      logout: "auth/logout",
    }),
    getEntries() {
      axios.get('/entries').then(response => {
        console.log(response.data);
        this.items = response.data;
      })
    },
    getEntryById(id) {
      this.edit = true;
      this.id = id;
      axios.get('/entries/'+id).then(response => {
        this.form = response.data;

        let tags = [];

        response.data.tags.forEach(tag => {
          tags.push(tag.title);
        })

        this.form.tags = tags;
        console.log([this.form, response.data]);
      })
    },
    getStatistics() {
      axios.get('/statistics').then(response => {
        this.statistics = response.data;
        console.log(this.statistics);
      })
    },
    getOptions() {
      axios.get('/options').then(response => {
        this.options = response.data;
      })
    },
    createEntry() {
      if (!this.edit) {
        axios.post('/entries', this.form).then(response => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: response.data.message,
              icon: 'EditIcon',
              variant: 'success',
            },
          })
        });
      } else {
        axios.post('/entries/'+this.id, this.form).then(response => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: response.data.message,
              icon: 'EditIcon',
              variant: 'success',
            },
          })
        });
      }
      this.getEntries();
      this.getOptions();
      this.getStatistics();
    }
  }
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

.tag-badge {
  margin: 2px;
}

li.form-tag-card {
  height: 30px;
  margin: 1px;
  background: none;
  box-shadow: none;
}
.custom-form-tags {
  background: none;
  padding: 0px;
  border: none;
}
</style>
