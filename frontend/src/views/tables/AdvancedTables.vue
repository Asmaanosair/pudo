<template>
  <CRow>
    <CCol sm="12">
      <CCard>
        <CCardHeader>
          <CIcon name="cil-grid"/> Advanced 
          <CLink 
            href="https://coreui.io/vue/docs/components/table"
            target="blank"
          >
            CDataTable
          </CLink> application
        </CCardHeader>
        <DemoTable/>
      </CCard>
      <CCard>
        <CCardHeader>
          Backend integration example
        </CCardHeader>
        <BackendTable/>
      </CCard>
      <CCard>
        <CCardHeader>
          Current table items download to xlsx/csv table
        </CCardHeader>
        <DownloadTable/>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import BackendTable from './BackendTable'
import DemoTable from './DemoTable'
import DownloadTable from './DownloadTable'

export default {
  name: 'AdvancedTables',
  components: {
    BackendTable,
    DemoTable,
    DownloadTable
  }
}
</script>
