<template>
  <CRow style="height:101vh !important; padding-top:0!important">

    <template>
      <div class="form-group" style="  position: absolute;
        left: 13%;
        z-index: 100;
        display: block;
        top: 66px;
 ">
        <select type="text" v-model="countryId" @change="getCity()"

                :class="{
                'form-control': true
              }"
        >

          <option  value=""> Country</option>
          <option
            v-for="(country, index) in countries"
            :value="country.id"
            :key="index"
          >
            {{ country.name }}
          </option>
        </select>

      </div>
    </template>
    <template>
      <div class="form-group" style=" position: absolute;
   left: 20%;
       width: 96px;
    z-index: 100;
    top: 66px;
    display: block;">

        <select

          @change="getcityPolygon()"
          v-model="city"
          :class="{
                  'form-control': true,
                }"
        >

          <option  value=""> City</option>

          <option
            v-for="(city, index) in cities"
            :key="index"
            :value="city.st_astext"
          >{{ city.name }}</option>
        </select>
      </div>
    </template>
    <GmapMap
      :options="{ styles: styles }"
      :center="googleCenter"
      :zoom="12"
      class="google-map-order"
      id="mapping"
    >
      <GmapInfoWindow
        :options="infoOptions"
        :position="infoWindowPos"
        :opened="infoWinOpen"
        @mouseout="infoWinOpen = false"
      >
        <CLink target="_blank" :href="infoLink">{{ infoContent }}</CLink>

      </GmapInfoWindow>

      <GmapMarker
        :key="index"
        v-for="(m, index) in markers"
        :position="m.position"
        :title="m.title"
        :clickable="true"
        :icon="m.markerIcon"
        :draggable="m.draggable"
        @mouseover="toggleInfoWindow(m, index)"
      />
      <gmap-polygon
        :key="m.travelId"
        v-for="m in markers"
        :paths="m.travel"
        :options="{
          strokeColor: '#39f',
          strokeOpacity: '6.0',

          strokeWeight: '6'
        }"
      >
      </gmap-polygon>
      <gmap-polygon v-bind:path.sync="ptsArray" v-bind:options="{ strokeColor:'#ce2a2a',fillColor: '#e00707', }">
      </gmap-polygon>
      <gmap-polygon v-bind:path.sync="ptsArray2" v-bind:options="{ strokeColor:'#f5e038',fillColor: '#a5e735', }">
      </gmap-polygon>
    </GmapMap>

    <!--=================================== Start Google Map ===========================-->

    <div style="display:none" id="driver-map"></div>


    <CSidebar
      id="my-side-order"
      aside
      :show="sideShow"
      colorScheme="light"
      size="lg"
      :style="sideStyle"
    >
      <button hidden @click="testFleet()">test</button>
      <span class="close-order" @click="handleSideOrder()">x</span>
      <!--    overlaid-->

      <!--    @update:show="(val) => $store.commit('set', ['asideShow', val])"-->
      <!--      <CSidebarClose @click.native="sideShow=false"/>-->
      <button
        class="btn font-weight-bolder "
        v-if="mapDarkBtn"
        @click="whiteMap()"
      >
        White Map

        <CIcon name="cil-map" />
      </button>
      <button
        class="btn btn-success font-weight-bolder"
        style="background:black"
        v-else
        @click="darkMap()"
      >
        Dark Map
        <CIcon name="cil-map" />
      </button>

      <CTabs tabs class="nav-underline nav-underline-primary orders-tabs">
        <CTab >
          <template slot="title">
            <!--            <CIcon name="cil-list"/>-->
            <span class="change-map" @click="driverMap()">
              {{ $t("drivers") }}
            </span>
          </template>
          <CListGroup class="list-group-accent">
            <div>
              <div class="p-2">
                <div class="d-flex justify-content-between">



                  <input class="form-control" type="text" placeholder="Phone Or name "  @input="getInfo()" v-model="nameOrPhone">
                  <span class="input-group-text" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
</svg>
              </span>

                </div>


              </div>
              <hr>

            </div>
            <div class="p-2">
              <div class="d-flex justify-content-between">
                <p class="mb-0  font-weight-bolder">
                  Total Drivers:
                  <span class="badge badge-info">
                      {{
                      busyFleets.length +
                      onlineFleets.length +
                      freeFleets.length +
                      offlineFleets.length+
                      suspendedFleets.length
                    }}
                    </span>
                </p>
                <div class="col-6">
                  <p class="filters"  @click="showFilter=!showFilter"  >
                    Filters <i class=" cib-favro"></i>
                  </p>
                  <div v-if="showFilter" class="col-12" style="z-index: 100 ;position: absolute; background-color: white ;">
                    <div class="m-check">
                      <input type="checkbox" id="online" v-model="filter" @change="showDrivers('online')" value="online">
                      <label for="online">online</label>
                    </div>
                    <div class="m-check">
                      <input type="checkbox" id="offline" v-model="filter" @change="showDrivers('offline')" value="offline">
                      <label for="offline">offline</label>
                    </div>
                    <div class="m-check">
                      <input type="checkbox" id="busy" v-model="filter"  @change="showDrivers('busy')"  value="busy">
                      <label for="busy">busy</label>
                    </div>
                    <div class="m-check">
                      <input type="checkbox"  id="Suspended" v-model="filter" value="suspended"  @change="showDrivers('suspended')" >
                      <label for="Suspended">Suspended</label>
                    </div>
                    <div class="m-check">
                      <input type="checkbox" id="free" v-model="filter" value="free" @change="showDrivers('free')">
                      <label for="free">Free</label>
                    </div>
                  </div>
                </div>

              </div>
              <span class="font-weight-bolder">Drivers Status :</span>
              <span class="badge badge-success">
                  {{ onlineFleets.length }}
                </span>

              /
              <span class="badge badge-warning">
                  {{ busyFleets.length }}
                </span>
              /

              <span class="badge" style="background: gray;color: white;">
                  {{ freeFleets.length }}
                </span>
              /
              <span class="badge badge-danger">
                  {{ offlineFleets.length }}
                </span>
              /
              <span class="badge badge-primary">
                  {{ suspendedFleets.length }}
                </span>
            </div>
            </div>

            <CListGroupItem
              v-show="showOnline"
              style="color:white !important"
              class="list-group-item-accent-success bg-success  text-center
            font-weight-bold text-muted text-uppercase small"
            >
              {{ $t("online") }}
            </CListGroupItem>

            <CListGroupItem
              v-show="showOnline"
              v-for="fleet in fleets"
              v-if="
                fleet.status == 'online' &&

                  fleet.lat != null &&
                  fleet.lng != null
              "
              @click="focusOnFleet(fleet.lat, fleet.lng)"
              :key="fleet.id"
              href="#"
              class="list-group-item-accent-success list-group-item-divider"
            >
              <div>
                <div class="c-avatar float-right">
                  <img
                    class="c-avatar-img"
                    :src="avatarImg"
                    alt="admin@bootstrapmaster.com"
                  />
                </div>
                <div>
                  <strong>{{ fleet.name }}</strong>
                </div>
                <small class="text-muted mr-3">
                  <CIcon name="cil-list" />&nbsp;&nbsp;
                  {{ fleet.orders_count }}
                  {{ $t("orders") }}
                </small>

                <small class="text-muted">
                  {{ fleet.mobile }}
                </small>
                <div class="d-flex  align-items-center" style="margin-top:3px">
                  <p class="mb-0 text-gray">
                    Battery:
                  </p>
                  <div
                    class="progress"
                    style="width:64px;background:gray ;margin: 0 3px;position: relative;top: 2px;"
                  >
                    <div
                      class="progress-bar bg-info"
                      role="progressbar"
                      :style="'width:' + fleet.tank + '%'"
                      :aria-valuenow="fleet.tank"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      {{ fleet.tank }}%
                    </div>
                  </div>
                </div>
              </div>
            </CListGroupItem>

            <hr class="transparent mx-3 my-0" />
            <CListGroupItem
              v-show="showBusy"
              style="color:white !important;"
              class="list-group-item-accent-secondary bg-warning text-center
            font-weight-bold  text-uppercase small"
            >
              Busy
            </CListGroupItem>
            <CListGroupItem
              v-show="showBusy"
              v-for="fleet in fleets"
              v-if="
                fleet.status == 'busy' &&

                  fleet.lat != null &&
                  fleet.lng != null
              "
              @click="focusOnFleet(fleet.lat, fleet.lng)"
              :key="fleet.id"
              href="#"
              class="list-group-item-accent-secondary list-group-item-divider"
            >
              <div>
                <div class="c-avatar float-right">
                  <img
                    class="c-avatar-img"
                    :src="avatarImg"
                    alt="admin@bootstrapmaster.com"
                  />
                </div>
                <div>
                  <strong>{{ fleet.name }}</strong>
                </div>
                <small class="text-muted mr-3">
                  <CIcon name="cil-list" />&nbsp;&nbsp;
                  {{ fleet.orders_count }}
                  {{ $t("orders") }}
                </small>
                <small class="text-muted">
                  <CIcon name="cil-mobile" /> {{ fleet.mobile }}
                </small>
                <div class="d-flex  align-items-center" style="margin-top:3px">
                  <p class="mb-0 text-gray">
                    Battery:
                  </p>
                  <div
                    class="progress"
                    style="width:64px;background:gray ;margin: 0 3px;position: relative;top: 2px;"
                  >
                    <div
                      class="progress-bar bg-info"
                      role="progressbar"
                      :style="'width:' + fleet.tank + '%'"
                      :aria-valuenow="fleet.tank"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >
                      {{ fleet.tank }}%
                    </div>
                  </div>
                </div>
              </div>
            </CListGroupItem>

            <hr class="transparent mx-3 my-0" />
            <CListGroupItem
              v-show="showFree"
              style="color:white !important;  "
              class="list-group-item-accent-danger bg-dark text-center
            font-weight-bold  text-uppercase small"
            >
              Free
            </CListGroupItem>
            <CListGroupItem
              v-show="showFree"
              v-for="fleet in fleets"
              v-if="
                fleet.status == 'free' &&
                  fleet.lat != null &&
                  fleet.lng != null
              "
              :key="fleet.id"
              href="#"
              @click="focusOnFleet(fleet.lat, fleet.lng)"
              class="list-group-item-accent-danger list-group-item-divider"
            >
              <div class="c-avatar float-right">
                <img
                  class="c-avatar-img"
                  :src="avatarImg"
                  alt="admin@bootstrapmaster.com"
                />
              </div>
              <div>
                <strong>{{ fleet.name }}</strong>
              </div>
              <small class="text-muted mr-3">
                <CIcon name="cil-list" />&nbsp;&nbsp;
                {{ fleet.orders_count }}
                {{ $t("orders") }}
              </small>
              <small class="text-muted">
                <CIcon name="cil-mobile" /> {{ fleet.mobile }}
              </small>
              <div class="d-flex  align-items-center" style="margin-top:3px">
                <p class="mb-0 text-gray">
                  Battery:
                </p>
                <div
                  class="progress"
                  style="width:64px;background:gray ;margin: 0 3px;position: relative;top: 2px;"
                >
                  <div
                    class="progress-bar bg-info"
                    role="progressbar"
                    :style="'width:' + fleet.tank + '%'"
                    :aria-valuenow="fleet.tank"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  >
                    {{ fleet.tank }}%
                  </div>
                </div>
              </div>
            </CListGroupItem>
            <hr class="transparent mx-3 my-0" />
            <CListGroupItem
              v-show="showOffline"
              style="color:white !important;  "
              class="list-group-item-accent-danger bg-danger text-center
            font-weight-bold  text-uppercase small"
            >
              {{ $t("offline") }}
            </CListGroupItem>
            <CListGroupItem
              v-show="showOffline"
              v-for="fleet in fleets"
              v-if="
                fleet.status == 'offline' &&
                  fleet.lat != null &&
                  fleet.lng != null
              "
              :key="fleet.id"
              href="#"
              @click="focusOnFleet(fleet.lat, fleet.lng)"
              class="list-group-item-accent-danger list-group-item-divider"
            >
              <div class="c-avatar float-right">
                <img
                  class="c-avatar-img"
                  :src="avatarImg"
                  alt="admin@bootstrapmaster.com"
                />
              </div>
              <div>
                <strong>{{ fleet.name }}</strong>
              </div>
              <small class="text-muted mr-3">
                <CIcon name="cil-list" />&nbsp;&nbsp;
                {{ fleet.orders_count }}
                {{ $t("orders") }}
              </small>
              <small class="text-muted">
                <CIcon name="cil-mobile" /> {{ fleet.mobile }}
              </small>
              <div class="d-flex  align-items-center" style="margin-top:3px">
                <p class="mb-0 text-gray">
                  Battery:
                </p>
                <div
                  class="progress"
                  style="width:64px;background:gray ;margin: 0 3px;position: relative;top: 2px;"
                >
                  <div
                    class="progress-bar bg-info"
                    role="progressbar"
                    :style="'width:' + fleet.tank + '%'"
                    :aria-valuenow="fleet.tank"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  >
                    {{ fleet.tank }}%
                  </div>
                </div>
              </div>
            </CListGroupItem>
            <hr class="transparent mx-3 my-0" />
            <CListGroupItem
              v-show="showSuspended"
              style="color:white !important;  "
              class="list-group-item-accent-danger bg-primary text-center
            font-weight-bold  text-uppercase small"
            >
              Suspended
            </CListGroupItem>
            <CListGroupItem
              v-show="showSuspended"
              v-for="fleet in fleets"
              v-if="
                fleet.status == 'suspended' &&
                  fleet.lat != null &&
                  fleet.lng != null
              "
              :key="fleet.id"
              href="#"
              @click="focusOnFleet(fleet.lat, fleet.lng)"
              class="list-group-item-accent-danger list-group-item-divider"
            >
              <div class="c-avatar float-right">
                <img
                  class="c-avatar-img"
                  :src="avatarImg"
                  alt="admin@bootstrapmaster.com"
                />
              </div>
              <div>
                <strong>{{ fleet.name }}</strong>
              </div>
              <small class="text-muted mr-3">
                <CIcon name="cil-list" />&nbsp;&nbsp;
                {{ fleet.orders_count }}
                {{ $t("orders") }}
              </small>
              <small class="text-muted">
                <CIcon name="cil-mobile" /> {{ fleet.mobile }}
              </small>
              <div class="d-flex  align-items-center" style="margin-top:3px">
                <p class="mb-0 text-gray">
                  Battery:
                </p>
                <div
                  class="progress"
                  style="width:64px;background:gray ;margin: 0 3px;position: relative;top: 2px;"
                >
                  <div
                    class="progress-bar bg-info"
                    role="progressbar"
                    :style="'width:' + fleet.tank + '%'"
                    :aria-valuenow="fleet.tank"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  >
                    {{ fleet.tank }}%
                  </div>
                </div>
              </div>
            </CListGroupItem>
          </CListGroup>
        </CTab>
        <CTab active>
          <template slot="title">
            <!--            <CIcon name="cil-speech"/>-->
            <span class="change-map" @click="orderMap()">
              {{ $t("orders") }}</span
            >
          </template>
          <div class="p-2">
            <div class="d-flex justify-content-between">
              <input class="form-control" type="text" placeholder="Order Number "  @input="getInfo()" v-model="orderNumber">
              <span class="input-group-text" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
</svg>
              </span>

            </div>


          </div>

          <CListGroupItem
            v-for="order in orders"
            :key="order.id"
            @click="focusOnDriver(order.pick_up_lat, order.delivery_lng)"
            href="#"
            class="list-group-item-accent-success list-group-item-divider"
          >
            <div class="c-avatar float-right">
              <!-- <img
                class="c-avatar-img"
                srcasset("markers/1.png"
                alt="admin@bootstrapmaster.com"
              /> -->
              <p :class="' like-img ' + 'bg-' + order.status.class">
                {{
                  order.customer_name != null
                    ? order.customer_name.substring(0, 1)
                    : ""
                }}
              </p>
              <br />
              <p class="my-customer-name">
                {{ order.customer_name }}
              </p>
            </div>

            <div class="my-locale">
              <span :class="' my-p ' + 'bg-' + order.status.class">
                {{
                  order.status != null ? order.status.name.substring(0, 1) : ""
                }}
              </span>
            </div>
            <div>
              <strong
              ><span :class="' the-code ' + 'text-' + order.status.class"
              >OrderID:</span
              >
                {{ order.id }}</strong
              >
            </div>
            <small class="text-muted mr-3">
              <!-- <CIcon name="cil-list" /> -->
              <img
                class="my-money"
                src="https://www.vhv.rs/dpng/d/511-5119015_blue-money-icon-png-png-download-habitat-for.png"
                alt=""
              />
              <strong> {{ order.total_price }} SR </strong>
            </small>
            <small class="text-muted my-date-delivery">
              <CIcon name="cil-mobile" /> {{ order.delivery_time }}
            </small>
            <small
              class="te
            xt-muted"
            >
              <CBadge class="my-status" :color="order.status.class">
                {{ order.status.name }}</CBadge
              >
            </small>
          </CListGroupItem>
        </CTab>

      </CTabs>
    </CSidebar>
  </CRow>
</template>

<script>
import { latLngBounds } from "leaflet";
import {
  LMap,
  LTileLayer,
  LMarker,
  LIcon,
  LPolyline,
  LLayerGroup,
  LTooltip,
  LPopup,
  LControlZoom,
  LControlAttribution,
  LControlScale,
  LControlLayers
} from "vue2-leaflet";
import axios from "axios";
import { asset } from "@codinglabs/laravel-asset";

import * as VueGoogleMaps from "vue2-google-maps";
import Vue from "vue";

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyBChUzS-ZK4363fr2b_CAvd-zMYugstSWQ"
  }
});

const tileProviders = [
  {
    name: "OpenStreetMap",
    visible: true,
    attribution:
      '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
    url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
  }
  // {
  //   name: 'OpenTopoMap',
  //   visible: false,
  //   url: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
  //   attribution:
  //     'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)',
  // },
];

export default {
  name: "Example",
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LIcon,
    LPolyline,
    LLayerGroup,
    LTooltip,
    LPopup,
    LControlZoom,
    LControlAttribution,
    LControlScale,
    LControlLayers
  },
  data() {
    return {
      cities: {},
      city:"",
      countryId:"",
      filter:['online','offline','suspended','free','busy'],
      showFilter:false,
      showSuspended:true,
      showFree:true,
      showOnline:true,
      showOffline:true,
      showBusy:true,
      countries:{},
      mapDarkBtn: true,
      nameOrPhone:'',
      orderNumber:'',
      //===================================== Start google Map =======================================
      googleCenter: { lat: 24.7517922987, lng: 46.5921405535 },
      wktcity:"POLYGON ((46.717300415039055 24.637655489967766, 46.69429779052734 24.63422270086176, 46.70236587524414 24.617213400153744, 46.71987533569336 24.621582982714266, 46.73154830932617 24.630477732453905, 46.7277717590332 24.640308035127767, 46.717300415039055 24.637655489967766))",
      wktcountry:"POLYGON ((46.05468749999999 28.9600886880068, 38.7158203125 23.926013033021192, 41.39648437499999 18.521283325496277, 49.658203125 18.187606552494625, 55.06347656249999 22.350075806124867, 46.05468749999999 28.9600886880068))",
      infoContent: "",
      infoLink: "",
      infoWindowPos: {
        lat: 0,
        lng: 0
      },
      infoWinOpen: false,
      currentMidx: null,
      // optional: offset infowindow so it visually sits nicely on top of our marker
      infoOptions: {
        pixelOffset: {
          width: 0,
          height: -35
        }
      },
      styles: [
        { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
        {
          elementType: "labels.text.stroke",
          stylers: [{ color: "#242f3e" }]
        },
        {
          elementType: "labels.text.fill",
          stylers: [{ color: "#746855" }]
        },
        {
          featureType: "administrative.locality",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }]
        },
        {
          featureType: "poi",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }]
        },
        {
          featureType: "poi.park",
          elementType: "geometry",
          stylers: [{ color: "#263c3f" }]
        },
        {
          featureType: "poi.park",
          elementType: "labels.text.fill",
          stylers: [{ color: "#6b9a76" }]
        },
        {
          featureType: "road",
          elementType: "geometry",
          stylers: [{ color: "#38414e" }]
        },
        {
          featureType: "road",
          elementType: "geometry.stroke",
          stylers: [{ color: "#212a37" }]
        },
        {
          featureType: "road",
          elementType: "labels.text.fill",
          stylers: [{ color: "#9ca5b3" }]
        },
        {
          featureType: "road.highway",
          elementType: "geometry",
          stylers: [{ color: "#746855" }]
        },
        {
          featureType: "road.highway",
          elementType: "geometry.stroke",
          stylers: [{ color: "#1f2835" }]
        },
        {
          featureType: "road.highway",
          elementType: "labels.text.fill",
          stylers: [{ color: "#f3d19c" }]
        },
        {
          featureType: "transit",
          elementType: "geometry",
          stylers: [{ color: "#2f3948" }]
        },
        {
          featureType: "transit.station",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }]
        },
        {
          featureType: "water",
          elementType: "geometry",
          stylers: [{ color: "#17263c" }]
        },
        {
          featureType: "water",
          elementType: "labels.text.fill",
          stylers: [{ color: "#515c6d" }]
        },
        {
          featureType: "water",
          elementType: "labels.text.stroke",
          stylers: [{ color: "#17263c" }]
        }
      ],
      styles2: [
        { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
        {
          elementType: "labels.text.stroke",
          stylers: [{ color: "#242f3e" }]
        },
        {
          elementType: "labels.text.fill",
          stylers: [{ color: "#746855" }]
        },
        {
          featureType: "administrative.locality",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }]
        },
        {
          featureType: "poi",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }]
        },
        {
          featureType: "poi.park",
          elementType: "geometry",
          stylers: [{ color: "#263c3f" }]
        },
        {
          featureType: "poi.park",
          elementType: "labels.text.fill",
          stylers: [{ color: "#6b9a76" }]
        },
        {
          featureType: "road",
          elementType: "geometry",
          stylers: [{ color: "#38414e" }]
        },
        {
          featureType: "road",
          elementType: "geometry.stroke",
          stylers: [{ color: "#212a37" }]
        },
        {
          featureType: "road",
          elementType: "labels.text.fill",
          stylers: [{ color: "#9ca5b3" }]
        },
        {
          featureType: "road.highway",
          elementType: "geometry",
          stylers: [{ color: "#746855" }]
        },
        {
          featureType: "road.highway",
          elementType: "geometry.stroke",
          stylers: [{ color: "#1f2835" }]
        },
        {
          featureType: "road.highway",
          elementType: "labels.text.fill",
          stylers: [{ color: "#f3d19c" }]
        },
        {
          featureType: "transit",
          elementType: "geometry",
          stylers: [{ color: "#2f3948" }]
        },
        {
          featureType: "transit.station",
          elementType: "labels.text.fill",
          stylers: [{ color: "#d59563" }]
        },
        {
          featureType: "water",
          elementType: "geometry",
          stylers: [{ color: "#17263c" }]
        },
        {
          featureType: "water",
          elementType: "labels.text.fill",
          stylers: [{ color: "#515c6d" }]
        },
        {
          featureType: "water",
          elementType: "labels.text.stroke",
          stylers: [{ color: "#17263c" }]
        }
      ],
      //===================================== End google Map =======================================

      showMap: true,
      sideStyle: {
        position: "fixed",
        overflowY: "scroll",
        top: 0,
        bottom: 0
      },
      fleets: [],
      orders: [],
      sideShow: true,
      activeBtnMap: true,
      regex : /\(([^()]+)\)/g,
      Rings :[],
      Rings2 :[],
      results:[],
      results2:[],
      ptsArray:[],
      ptsArray2:[],
      pointsData:[],
      pointsData2:[],


      mapDriverLat: 25.025965,
      mapDriverLng: 47.275023,
      avilableFleets: [],
      offlineFleets: [],
      onlineFleets: [],
      busyFleets: [],
      suspendedFleets: [],
      freeFleets: [],
      center: [41.0140076, 28.6829777],
      opacity: 0.6,
      token: "your token if using mapbox",
      mapOptions: {
        zoomControl: false,
        attributionControl: false,
        zoomSnap: true
      },
      zoom: 3,
      minZoom: 1,
      maxZoom: 15,
      zoomPosition: "topleft",
      attributionPosition: "bottomright",
      layersPosition: "topleft",
      attributionPrefix: "Vue2Leaflet",
      imperial: false,
      Positions: ["topleft", "topright", "bottomleft", "bottomright"],
      tileProviders: tileProviders,
      iconSize: 35,
      markers: [],
      avatarImg: asset("img/avatars/1.png"),
      bounds: latLngBounds(
        // TODO: make this to be the first and last order
        { lat: 25.025965, lng: 47.275023 },
        { lat: 24.592777, lng: 46.359089 }
      )
    };
  },
  computed: {
    dynamicSize() {
      return [this.iconSize, this.iconSize * 1.15];
    },
    dynamicAnchor() {
      return [this.iconSize / 2, this.iconSize * 1.15];
    }
  },

  mounted: function() {

    this.getInfo();
    this.country();

  },

  methods: {
    createPoly($wkt){
      this.results=[]
      this.Rings=[]
      while( this.results = this.regex.exec($wkt) ) {
        this.Rings.push( this.results[1] );
        console.log(this.results)
      }
      for(let i=0;i<this.Rings.length;i++){
        this.AddPoints(this.Rings[i]);
      }
    },
    createPoly2($wkt){
      this.results2=[]
      this.Rings2=[]
      while( this.results2 = this.regex.exec($wkt) ) {
        this.Rings2.push( this.results2[1] );
        console.log(this.results2)
      }
      for(let i=0;i<this.Rings2.length;i++){
        this.AddPoints2(this.Rings2[i]);
      }
    },
    getCity() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/cities/"+this.countryId+
          "?token=" +
          localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response.data);
          self.cities = response.data.cities;
          // let self = this;
          self.createPoly(response.data.countrygeom.st_astext)
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    AddPoints(data){
      this.pointsData=data.split(",");
      for (let i=0;i<this.pointsData.length;i++)
      {
        let xy=this.pointsData[i].split(" ");
        let LatLng={ lng:parseFloat(xy[0]),lat:parseFloat(xy[1])}
        this.ptsArray.push(LatLng);

      }

      this.googleCenter = this.ptsArray[0];
      console.log('Polygon1')
      console.log(this.ptsArray)
      return  this.ptsArray



    },
    AddPoints2(data){
      this.pointsData2=data.split(",");
      for (let i=0;i<this.pointsData2.length;i++)
      {
        let xy=this.pointsData2[i].split(" ");
        let LatLng={ lng:parseFloat(xy[0]),lat:parseFloat(xy[1])}

        this.ptsArray2.push(LatLng);

      }

      this.googleCenter = this.ptsArray2[0];
      console.log('Polygon2')
      console.log(this.ptsArray2)
      return  this.ptsArray2




    },
    getPolygon(){
      let self = this;
      this.getCity()
      self.googleCenter = this.ptsArray[0];

    },
    getcityPolygon(){
      let self = this;
      this.ptsArray2=[]
      self.createPoly2(self.city)

    },
    country() {
      let self = this;
      axios
        .get("/api/cities?token=" + localStorage.getItem("api_token"))
        .then(function(response) {
          self.countries = response.data.countries;
        })
        .catch(function(error) {
          console.log(error);
          self.$router.push({ path: "login" });
        });
    },
    showDrivers($test){
      //  this.filter.includes($test)
      // showSuspended:true,
      // showFree:true,
      // showOnline:true,
      // showOffline:true,
      // showBusy:true,
      if(this.filter.includes($test)){
        if($test=='online'){
          this.showOnline=true
        }if($test=='free'){
          this.showFree=true
        }if($test=='offline'){
          this.showOffline=true
        }
        if($test=='busy'){
          this.showBusy=true
        }
        if($test=='suspended'){
          this.showSuspended=true
        }
      }else {
        if($test=='online'){
          this.showOnline=false
        }if($test=='free'){
          this.showFree=false
        }if($test=='offline'){
          this.showOffline=false
        }
        if($test=='busy'){
          this.showBusy=false
        }
        if($test=='suspended'){
          this.showSuspended=false
        }
      }

    },
    whiteMap() {
      this.mapDarkBtn = false;
      this.styles = "";
      this.truckDrivers(this.fleets, this.styles);
    },
    darkMap() {
      this.mapDarkBtn = true;
      this.styles = this.styles2;
      this.truckDrivers(this.fleets, this.styles);
    },

    toggleInfoWindow(marker, idx) {
      this.infoWindowPos = marker.position;
      this.infoContent = marker.title;
      this.infoLink = marker.www;
      // check if its the same marker that was selected if yes toggle
      if (this.currentMidx === idx) {
        this.infoWinOpen = !this.infoWinOpen;
      } else {
        // if different marker set infowindow to open and reset current marker index
        this.currentMidx = idx;
        this.infoWinOpen = true;
      }
    },
    testFleet() {
      self = this;
      let driver = {
        active: 1,
        age: null,
        application_status_id: null,
        bank_iban: null,
        bank_name: null,
        block: 0,
        city_id: null,
        code: "12358",
        complete: 0,
        contract_type: null,
        country: "",
        created_at: "2020-06-16T21:27:11.000000Z",
        device_token: null,
        gender: "",
        id: 3,
        identity: "4534545435625",
        image: null,
        last_login: null,
        lat: 29,
        lng: 46,
        mobile: "42356543245",
        name: "test",
        nationality: null,
        nationalityId: null,
        orders_count: "2",
        status: "online",
        supplier_id: null,
        supplier_uuid: "",
        tank: 50,
        updated_at: "2020-06-16T21:27:11.000000Z",
        user_id: 1,
        uuid: "",
        vehicle_type: null,
        verification_code: null
      };

      let driverTarget = self.fleets.find(item => {
        return item.id == driver.id;
      });

      let index = self.fleets.indexOf(driverTarget);
      if (index !== -1) {
        driverTarget.tank = driver.tank;
        driverTarget.lat = driver.lat;
        driverTarget.lng = driver.lng;
        driverTarget.status = driver.status;
        driverTarget.orders_count = driver.orders_count;
        self.fleets[index] = driverTarget;
      } else {
        self.fleets.push(driver);
      }
      self.truckDrivers(self.fleets, self.styles);
    },

    focusOnFleet(newLat, newLng) {
      window.map.setCenter({
        lat: parseFloat(newLat),
        lng: parseFloat(newLng)
      });
    },
    truckDrivers(arrLatLng, myStyle) {
      let options = {
        center: { lat: this.mapDriverLat, lng: this.mapDriverLng },
        zoom: 11,
        styles: myStyle
      };

      window.map = new google.maps.Map(
        document.getElementById("driver-map"),
        options
      );
      let iconTarget;
      this.offlineFleets = [];
      this.onelineFleets = [];
      this.avilableFleets = [];
      this.busyFleets = [];
      this.onlineFleets= [];
      this.busyFleets= [];
      this.suspendedFleets= [];
      this.freeFleets= [];
      arrLatLng.forEach(item => {
        if (item.lat != null && item.lng != null) {
          if (item.status == "offline") {
            this.offlineFleets.push(item);
          }
          if (item.status == "online") {
            this.onlineFleets.push(item);
          }
          if (item.status == "busy") {
            this.busyFleets.push(item);
          }
          if (item.status == "free") {
            this.freeFleets.push(item);
          }
          if (item.status == "suspended") {
            this.suspendedFleets.push(item);
          }
          // else {
          //   if (item.orders_count == 0) {
          //     this.avilableFleets.push(item);
          //   } else {
          //     this.busyFleets.push(item);
          //   }
          // }
        }
      });

      for (let i = 0; i < arrLatLng.length; i++) {
        if (arrLatLng[i].lat != null && arrLatLng[i].lng != null) {
          if (arrLatLng[i].status == "free") {
            iconTarget =
              "https://www.grouplah.com/resources/Images/GoogleMaps/Map-Marker-grey.png";
          }
          if (arrLatLng[i].status == "online") {
            iconTarget =
              "https://icon-library.com/images/marker-icon-png/marker-icon-png-19.jpg";
          }
          if (arrLatLng[i].status == "busy") {
            iconTarget =
              "https://www.pngix.com/pngfile/big/87-878794_hexagym-yellow-map-marker-png-transparent-png.png";
          }
          if (arrLatLng[i].status == "suspended") {
            iconTarget =
              "https://upload.wikimedia.org/wikipedia/commons/thumb/8/88/Map_marker.svg/390px-Map_marker.svg.png";
          }
          if (arrLatLng[i].status == "offline") {
            iconTarget =
              "data:image/png;base64,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";
          }
          addMarker({
            coords: {
              lat: parseFloat(arrLatLng[i].lat),
              lng: parseFloat(arrLatLng[i].lng)
            },
            fleet_name: arrLatLng[i].name,
            fleet_orders_count: arrLatLng[i].orders_count,
            fleet_mobile: arrLatLng[i].mobile,
            icon: iconTarget,
            tank: arrLatLng[i].tank
          });

          function addMarker(props) {
            let marker = new google.maps.Marker({
              position: props.coords,
              icon: {
                url: props.icon,
                scaledSize: { width: 35, height: 35 }
              },
              map: map
            });

            let info = new google.maps.InfoWindow({
              content: `<div class="p-1">
           <p class="mb-0"><span class="font-weight-bold text-success"> name: </span> ${props.fleet_name} </p>
           <p class="mb-0"><span class="font-weight-bold text-success" > order count: </span> ${props.fleet_orders_count} </p>
           <p class="mb-0"><span class="font-weight-bold text-success"> mobile: </span> ${props.fleet_mobile} </p>
           <div class="d-flex mb-0">
           <p class="mb-0 font-weight-bold text-success"> Battery:
           </p>

           <div class="progress " style="width:64px;background:gray ;margin: 0 3px " >
                  <div class="progress-bar bg-info" role="progressbar" style="width:${props.tank}%;" aria-valuenow="${props.tank}" aria-valuemin="0" aria-valuemax="100">${props.tank}%</div>
           </div>
           </div>
           </div>`
            });
            // info.open(map, marker);

            marker.addListener("mouseover", function() {
              info.open(map, marker);
            });
            marker.addListener("mouseout", function() {
              info.close(map, marker);
            });
          }
        }
      }
    },
    handleSideOrder() {
      let sideOrder = document.getElementById("my-side-order");
      sideOrder.classList.toggle("handle-order");
    },

    fullMap() {
      let theMap = document.getElementById("mapping");
      this.activeBtnMap = false;
      theMap.style.position = "absolute";
      theMap.classList.add("full-map");
    },

    defaultMap() {
      let theMap = document.getElementById("mapping");
      this.activeBtnMap = true;
      theMap.style.position = "relative";
      theMap.classList.remove("full-map");
    },
    orderMap() {
      document.getElementById("driver-map").style.display = "none";
      document.getElementById("mapping").style.display = "block";
    },
    driverMap() {
      document.getElementById("driver-map").style.display = "block";
      document.getElementById("mapping").style.display = "none";
    },

    showOrder(item) {
      console.log(item);
    },
    getInfo() {
      let self = this;
      axios
        .get("/api/map-data?token=" + localStorage.getItem("api_token"),{
          params: {
            nameOrPhone: self.nameOrPhone,
            orderNumber: self.orderNumber,

          }
        })
        .then(function(response) {
          const data = { ...response.data };

          self.fleets = data.fleets;

          console.log(self.fleets);

          self.truckDrivers(data.fleets, self.styles);

          self.orders = response.data.orders;
          self.markers = [];
          data.orders.map(order => {
            const deliveryOrder = {
              id: "delivery" + order.id,
              orderId: order.id,
              position: {
                lat: parseFloat(order.delivery_lat),
                lng: parseFloat(order.delivery_lng)
              },
              title:
                " Delivery point order Id: " +
                order.id +
                " Code: " +
                order.code,
              www:"#/orders/"+ order.id,
              draggable: false,
              visible: true,
              markerIcon: {
                url: asset("markers/delivery.png"),
                scaledSize: { width: 40, height: 40 }
              },
              travel: [
                [
                  { lat: order.pick_up_lat, lng: order.pick_up_lng },

                  { lat: order.delivery_lat, lng: order.delivery_lng }
                ]
              ],
              travelId: "td" + order.id
            };
            self.markers.push(deliveryOrder);

            const pickUpOrder = {
              id: "pickup" + order.id,
              orderId: order.id,
              position: {
                lat: parseFloat(order.pick_up_lat),
                lng: parseFloat(order.pick_up_lng)
              },
              www:"#/orders/"+ order.id,
              title:
                " PickUp point order Id: " + order.id + " Code: " + order.code,
              draggable: false,
              visible: true,
              markerIcon: {
                url: asset("markers/pickup.png"),
                scaledSize: { width: 40, height: 40 }
              },
              travel: [
                [
                  { lat: order.pick_up_lat, lng: order.pick_up_lng },

                  { lat: order.delivery_lat, lng: order.delivery_lng }
                ]
              ],
              travelId: "tp" + order.id
            };

            self.markers.push(pickUpOrder);
          });

          console.log(self.markers);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    focusOnDriver(lat, lng) {
      let self = this;
      self.googleCenter = { lat: lat, lng: lng };
    }
  },

  created() {
    let self = this;

    self.fleets = [];
    this.$pusher.subscribe("fleet-location");
    this.$pusher.bind("App\\Events\\LocationNow", data => {
      console.log("the location is here");
      console.log(data);
      self = this;
      let driver = data.data.user;
      if (driver.tank == 0) {
        driver.tank = 90;
      }
      let driverTarget = self.fleets.find(item => {
        return item.id == driver.id;
      });

      let index = self.fleets.indexOf(driverTarget);

      if (index !== -1) {
        driverTarget.tank = driver.tank;
        driverTarget.lat = driver.lat;
        driverTarget.lng = driver.lng;
        driverTarget.status = driver.status;
        driverTarget.orders_count = driver.orders_count;
        self.fleets[index] = driverTarget;
      } else {
        self.fleets.push(driver);
      }
      self.truckDrivers(self.fleets, self.styles);
    });

    this.$pusher.bind("App\\Events\\OrderOperation", data => {
      console.log("the order is here");
      console.log(data);

      let order = self.orders.find(order => order.id === data.order.id);
      let index = self.orders.indexOf(order);

      let previosStatuses = [8, 9, 10, 11];
      if (order && !previosStatuses.includes(data.order.status.id)) {
        let keys = Object.keys(order);
        keys.map(key => {
          self.orders[index][key] = data.order[key];
        });
      } else if (order && previosStatuses.includes(data.order.status.id)) {
        self.orders.splice(index, 1);
      } else {
        const deliveryOrderMarker = {
          id: "delivery" + data.order.id,
          orderId: data.order.id,
          position: {
            lat: parseFloat(data.order.delivery_lat),
            lng: parseFloat(data.order.delivery_lng)
          },

          title:
            " Delivery point order Id: " +
            data.order.id +
            " Code: " +
            data.order.code,
          draggable: false,
          visible: true,
          markerIcon: {
            url: asset("markers/delivery.png"),
            scaledSize: { width: 40, height: 40 }
          },
          travel: [
            [
              { lat: data.order.pick_up_lat, lng: data.order.pick_up_lng },
              { lat: data.order.delivery_lat, lng: data.order.delivery_lng }
            ]
          ],
          travelId: "td" + order.id
        };

        self.markers.push(deliveryOrderMarker);

        const pickUpOrderMarker = {
          id: "pickup" + data.order.id,
          orderId: data.order.id,
          position: {
            lat: parseFloat(data.order.pick_up_lat),
            lng: parseFloat(data.order.pick_up_lng)
          },
          title:
            "  PickUp point order Id: " + order.id + " Code: " + order.code,
          draggable: false,
          visible: true,
          markerIcon: {
            url: asset("markers/delivery.png"),
            scaledSize: { width: 40, height: 40 }
          },
          travel: [
            [
              { lat: data.order.pick_up_lat, lng: data.order.pick_up_lng },
              { lat: data.order.delivery_lat, lng: data.order.delivery_lng }
            ]
          ],
          travelId: "tp" + data.order.id
        };


        self.markers.push(pickUpOrderMarker);

        self.orders.push(data.order);

      }
    });
  },




};
</script>
