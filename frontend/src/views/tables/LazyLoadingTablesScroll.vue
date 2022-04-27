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
            :sorter="{ external: true, resetable: true }"
            :columnFilter="{ external: true, lazy: true }"
            :table-filter="{ external: true, lazy: true }"
            :sorter-value.sync="sorter"
            :column-filter-value.sync="columnFilter"
            :table-filter-value.sync="tableFilter"
            :addTableClasses="lazyTableClass"
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

const fields = [
  { key: 'username', _style:'width:40%' },
  'registered',
  { key: 'role', _style:'width:20%;' },
  { key: 'status', _style:'width:20%;' },
  { 
    key: 'show_details', 
    label: '', 
    _style: 'width:1%', 
    sortable: false, 
    filterable: false
  }
]

export default {
  name: 'AdvancedTables',
  data () {
    return {
      fields,
      filter: {
        author: '',
        title: '',
        content: '',
        status: '',
        note_type: ''
      },
      lazyTableFields: ['author', 'title', 'content', 'applies_to_date', 'status', 'note_type'],
      scrolledElement: null,
      lazyTableClass: "lazyTable",
      items: [],
      page: 1,
      scrollHist: 0,
      scrollConst: 500,
      scrollBlockFlag: false,
      activePage: 1,
      sorter: {column: '', asc: false},
      tableFilter: '',
      columnFilter: {},
      itemsLimit: 20,
    }
  },
  watch: {
    activePage(){
      this.items = [];
      this.getNotes();
    },
  	sorter: {
    	handler(){
        this.items = [];
      	this.getNotes();
      },
      deep: true
    },
    tableFilter(){
      this.items = [];
      this.getNotes();
    },
    columnFilter(){
      this.items = [];
      this.getNotes();
    }
  },
  methods: {
    handleScroll (e) {
      if(this.scrollBlockFlag === false){
          let self = this;
          let scrl = e.target.scrollTop;
          let elt = document.getElementsByClassName("lazyTable");
          elt = elt[0];
          if( elt.scrollHeight - this.scrollConst <= scrl ){
            this.page++;
            this.getNotes();
            self.scrollBlockFlag = true;
            setTimeout(function(){
              self.scrollBlockFlag = false;
            },1000);
          }
      }
    },
    getNotes (){
      let self = this;
      axios.post('/api/lazyTable?page=' + self.page, 
        {
          sorter:       self.sorter,
          tableFilter:  self.tableFilter,
          columnFilter: self.columnFilter,
          itemsLimit:   self.itemsLimit,
        }
       )
      .then(function (response) {
        self.items = self.items.concat(response.data.data);
      }).catch(function (error) {
        console.log(error);
      });
    },
  }, 
  mounted: function(){
    this.scrolledElement = document.getElementsByClassName("lazyTable");
    this.scrolledElement[0].onscroll = this.handleScroll;
    this.items = [];
    this.getNotes();
  },
  destroyed () {
    this.scrolledElement = null;
  }


}
</script>
