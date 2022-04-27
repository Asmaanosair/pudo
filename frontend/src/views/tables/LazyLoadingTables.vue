<template>
  <CRow>
    <CCol sm="12">
      <CCard>
        <CCardHeader>
          Lazy loading functionality presentation
          <div class="card-header-actions">
            <a
              href="https://coreui.io/vue/docs/3.0/components/Table"
              class="card-header-action"
              rel="noreferrer noopener"
              target="_blank"
            >
              <small class="text-muted">docs</small>
            </a>
          </div>
        </CCardHeader>
        <CCardBody>
          <CDataTable
            :items="items"
            :fields="lazyTableFields"
            index-column
            hover
            footer
            table-column
            items-per-page-select
            :sorter="{ external: true, resetable: true }"
            :columnFilter="{ external: true, lazy: true }"
            :table-filter="{ external: true, lazy: true }"
            @pagination-change="changeItemsLimit"
            :sorter-value.sync="sorter"
            :column-filter-value.sync="columnFilter"
            :table-filter-value.sync="tableFilter"
            :loading="loading"
          >
              <template #author="{item}">
                <td>
                  <strong>{{item.author}}</strong>
                </td>
              </template>
              <template #title="{item}">
                <td>
                  <strong>{{item.title}}</strong>
                </td>
              </template>
              <template #content="{item}">
                <td>
                  {{item.content}}
                </td>
              </template>
              <template #applies_to_date="{item}">
                <td>
                  {{item.applies_to_date}}
                </td>
              </template>
              <template #status="{item}">
                <td>
                  <CBadge :color="item.status_class">{{item.status}}</CBadge>
                </td>
              </template>
              <template #note_type="{item}">
                <td>
                  <strong>{{item.note_type}}</strong>
                </td>
              </template>
          </CDataTable>
          <CPagination
            :pages="maxPages"
            :active-page.sync="activePage"
          />
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<style>
  .lazyTable{
    display: block;
    height: 450px;
    overflow-y: scroll;
  }

  .lazyTable tr{
    height:50px;
  }
</style>

<script>
import axios from 'axios'

export default {
  name: 'AdvancedTables',
  data () {
    return {
      lazyTableFields: ['author', 'title', 'content', 'applies_to_date', 'status', 'note_type'],
      items: [],
      activePage: 1,
      maxPages: 1,
      sorter: {column: '', asc: false},
      tableFilter: '',
      columnFilter: {},
      itemsLimit: 10,
      loading: false
    }
  },
  watch: {
    activePage(){
      this.getNotes();
    },
  	sorter: {
    	handler(){
      	this.getNotes();
      },
      deep: true
    },
    tableFilter(){
      this.getNotes();
    },
    columnFilter(){
      this.getNotes();
    }
  },
  methods: {
    changeItemsLimit( val ){
      this.itemsLimit = val;
      this.getNotes();
    },
    getNotes (){
      this.loading = true
      let self = this;
      this.items = [];
      axios.post('/api/lazyTable?page=' + self.activePage,
        {
          sorter:       self.sorter,
          tableFilter:  self.tableFilter,
          columnFilter: self.columnFilter,
          itemsLimit:   self.itemsLimit
        }
       )
      .then(function (response) {

        self.items = self.items.concat(response.data.data);
        self.maxPages = response.data.last_page;
        self.loading = false
      }).catch(function (error) {
        self.loading = false
        console.log(error);
      });
    },
    makeFilter(){
      this.getNotes();
    },
  },
  mounted: function(){
    this.getNotes();
  },
}
</script>
