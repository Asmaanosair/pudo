<template>
  <form @submit.prevent="submitForm">
    <CRow>
      <CCol col="12" lg="6">
        <CCard no-header>
          <CCardBody>
            <template slot="header">
              Create Users
            </template>
            <CAlert :show.sync="dismissCountDown" :color="alertColor" fade>
              ({{ dismissCountDown }}) {{ message }}
            </CAlert>
            <div class="form-group">
              <label>full name</label>
              <input
                type="text"
                v-on:keyup="onlyText($event)"
                :placeholder="'full name' + '...'"
                v-model.trim="$v.name.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.name.$error,
                  'is-valid': !$v.name.$invalid
                }"
              />
              <div v-if="!$v.name.$error" class="valid-feedback">
                your Full name is valid !
              </div>

              <div v-if="$v.name.$error" class="invalid-feedback">
                <span class="d-block" v-if="!$v.name.required">
                  Your Full name is required .
                </span>

                <span class="d-block" v-if="!$v.name.minLength">
                  Your Full name must have at least
                  {{ $v.name.$params.minLength.min }} letters
                </span>

                <span class="d-block" v-if="!$v.name.maxLength">
                  Your Full name must have at most
                  {{ $v.name.$params.maxLength.max }} letters
                </span>
              </div>
            </div>
            <div class="form-group">
              <label>mobile</label>
              <input
                v-on:keyup="onlyNumber($event)"
                type="text"
                :placeholder="'mobile' + '...'"
                v-model.trim="$v.mobile.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.mobile.$error,
                  'is-valid': !$v.mobile.$invalid
                }"
              />

              <div v-if="!$v.mobile.$error" class="valid-feedback">
                your phone is valid !
              </div>

              <div v-if="$v.mobile.$error" class="invalid-feedback">
                <span class="d-block" v-if="!$v.mobile.required">
                  Your phone is required .
                </span>
                <span class="d-block" v-if="!$v.mobile.numeric">
                  Your phone must be numbers
                </span>

                <span class="d-block" v-if="!$v.mobile.minLength">
                  Your phone must have at least
                  {{ $v.mobile.$params.minLength.min }} numbers
                </span>

                <span class="d-block" v-if="!$v.mobile.maxLength">
                  Your phone must have at most
                  {{ $v.mobile.$params.maxLength.max }} numbers
                </span>
                <span class="d-block" v-if="!$v.mobile.isStartWith">
                  Your phone must Start With 05
                </span>
                <span class="d-block" v-if="!$v.mobile.isUnique">
                  this phone is already be taken .
                </span>
              </div>
            </div>
            <div class="form-group">
              <label>Date Of Birth</label>
              <CInput
                type="date"
                :placeholder="'Date Of Birth' + '...'"
                v-model.trim="$v.age.$model"
                :class="{
                  'is-invalid': $v.age.$error,
                  'is-valid': !$v.age.$invalid
                }"
              >
              </CInput>

              <div v-if="theAge >= 18" class="my-valid">
                your age is valid !
              </div>

              <div v-if="$v.age.$error" class="invalid-feedback">
                <span class="d-block" v-if="!$v.age.required">
                  Your age is required
                </span>
                <span class="d-block" v-if="!$v.age.checkAge">
                  Your age must be 18 years or Greater Than 18
                </span>
              </div>
            </div>

            <div class="form-group">
              <p>Iqama /ID</p>

              <input
                v-on:keyup="onlyNumber($event)"
                type="text"
                :placeholder="'Iqama /ID' + '...'"
                v-model="identity"
                v-model.trim="$v.identity.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.identity.$error,
                  'is-valid': !$v.identity.$invalid
                }"
              />

              <div v-if="!$v.identity.$error" class="valid-feedback">
                Your Iqama /ID is valid
              </div>

              <div v-if="$v.identity.$error" class="invalid-feedback">
                <span class="d-block" v-if="!$v.identity.required">
                  Your Iqama /ID is required .
                </span>
                <span class="d-block" v-if="!$v.identity.numeric">
                  Your Iqama /ID must be numbers
                </span>

                <span class="d-block" v-if="!$v.identity.minLength">
                  Your Iqama /ID must have at least
                  {{ $v.identity.$params.minLength.min }} numbers
                </span>
              </div>
            </div>
            <label for="">Nationality</label>
            <select
              v-model.trim="$v.nationality.$model"
              :class="{
                'form-control': true,
                'is-invalid': $v.nationality.$error,
                'is-valid': !$v.nationality.$invalid
              }"
            >
              <option
                v-for="(national, index) in nationalities"
                :key="index"
                :value="national"
                >{{ national }}</option
              >
            </select>
            <div class="valid-feedback">
              your nationality is valid !
            </div>

            <div class="invalid-feedback">
              <span class="d-block" v-if="!$v.nationality.required">
                Your nationality is required .
              </span>
            </div>



            <div class="form-group">
              <p>{{ $t("password") }}</p>

              <input
                type="text"
                :placeholder="$t('password') + '...'"
                v-model="password"
                v-model.trim="$v.password.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.password.$error,
                  'is-valid': !$v.password.$invalid
                }"
              />

              <div v-if="!$v.password.$error" class="valid-feedback">
                your password is valid !
              </div>

              <div v-if="$v.password.$error" class="invalid-feedback">
                <span class="d-block" v-if="!$v.password.required">
                  Your password is required .
                </span>

                <span class="d-block" v-if="!$v.password.minLength">
                  Your password must have at least
                  {{ $v.password.$params.minLength.min }} numbers
                </span>
              </div>
            </div>
          </CCardBody>
        </CCard>
      </CCol>

      <CCol col="12" lg="6">
        <CCard no-header>
          <CCardBody>
            <div class="form-group">
              <label for="">gender</label>

              <select
                v-model.trim="$v.gender.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.gender.$error,
                  'is-valid': !$v.gender.$invalid
                }"
              >
                <option value="male"> male </option>
                <option value="female"> female</option>
              </select>
              <div class="valid-feedback">
                your gender is valid !
              </div>

              <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.gender.required">
                  Your gender is required .
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="">Country</label>
              <select
                @change="getCity()"
                v-model.trim="$v.country.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.country.$error,
                  'is-valid': !$v.country.$invalid
                }"
              >
                <option
                  v-for="(country, index) in countries"
                  :key="index"
                  :value="country.id"
                  >{{ country.name }}</option
                >
              </select>
              <div class="valid-feedback">
                your country is valid !
              </div>

              <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.country.required">
                  Your country is required .
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="">City</label>
              <select

                v-model.trim="$v.city.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.city.$error,
                  'is-valid': !$v.city.$invalid
                }"
              >
                <option
                  v-for="(city, index) in cities"
                  :key="index"
                  :value="city.id"
                  >{{ city.name }}</option
                >
              </select>
              <div class="valid-feedback">
                your city is valid !
              </div>

              <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.city.required">
                  Your city is required .
                </span>
              </div>
            </div>

            <!-- <label for="">Country</label>

          <input
            type="text"
            v-model="country"
            list="country"
            class="form-control"
          />

          <datalist id="country">
            <option
              class="form-control"
              v-for="(country, index) in countries"
              :value="country"
              :key="index"
            >
            </option>
          </datalist> -->

            <div class="form-group">
              <label for="">Vehicle Type</label>

              <select
                v-model.trim="$v.vehicle_type.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.vehicle_type.$error,
                  'is-valid': !$v.vehicle_type.$invalid
                }"
              >
                <option value="Motorcycle"> Motorcycle </option>
                <option value="Sedan "> Sedan </option>
                <option value="Mini Van "> Mini Van </option>
                <option value="Track "> Track </option>
              </select>
              <div class="valid-feedback">
                your vehicle_type is valid !
              </div>

              <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.vehicle_type.required">
                  Your vehicle_type is required .
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="">Bank Name</label>

              <select
                v-model.trim="$v.bank_name.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.bank_name.$error,
                  'is-valid': !$v.bank_name.$invalid
                }"
              >
                <option selected value="Saudi National Bank (SNB)">
                  Saudi National Bank (SNB)
                </option>
                <option value="Alrajhi Bank"> Alrajhi Bank </option>
                <option value="Alinma Bank"> Alinma Bank </option>
                <option value="Albilad Bank"> Albilad Bank </option>

                <option value="The Arab National Bank (ANB)">
                  The Arab National Bank (ANB)
                </option>
                <option value="Saudi Investment Bank (SAIB)">
                  Saudi Investment Bank (SAIB)
                </option>
                <option value="Aljazira Bank"> Aljazira Bank </option>
                <option value="Riyad Bank"> Riyad Bank </option>
                <option value="Alwwal & SABB Bank">
                  Alawwal & SABB Bank
                </option>
                <option value="Gulf International Bank (GIB)">
                  Gulf International Bank (GIB)
                </option>
                <option value="Banque Saudi Fransi">
                  Banque Saudi Fransi
                </option>
                <option value=" First Abu Dhabi Bank (FAB)">
                  First Abu Dhabi Bank (FAB)
                </option>
                <option value=" Emrates NBD Bank">
                  Emirates NBD Bank
                </option>
              </select>
              <div v-if="$v.bank_name.$error" class="invalid-feedback">
                <span class="d-block" v-if="!$v.bank_name.required">
                  Your bank_name is required .
                </span>
            </div>
            </div>
            <div class="form-group">
              <p>Bank Iban</p>

              <input
                type="text"
                :placeholder="'bank_iban' + '...'"
                v-model="bank_iban"
                v-model.trim="$v.bank_iban.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.bank_iban.$error,
                  'is-valid': !$v.bank_iban.$invalid
                }"
              >

              <div v-if="$v.bank_iban.$error" class="invalid-feedback">
                <span class="d-block" v-if="!$v.bank_iban.required">
                  Your bank_iban is required .
                </span>
              </div>
              <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.bank_iban.minLength">
                  Your Bank Iban must have at least
                  {{ $v.bank_iban.$params.minLength.min }} chars
                </span>
                <span class="d-block" v-if="!$v.bank_iban.isStartWith">
                  Your Bank Iban must Start With SA
                </span>
              </div>
            </div>
            <div role="group" class="form-group">
              <label class=""> Application Status </label>
              <select
                v-if="role == 'user,admin'"
                v-model.trim="$v.application_status_id.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.application_status_id.$error,
                  'is-valid': !$v.application_status_id.$invalid
                }"
              >
                <option
                  v-for="(status, index) in allStatus"
                  :value="status.id"
                  :key="index"
                >
                  {{ status.name }}
                </option>
              </select>

              <select
                v-else
                v-model.trim="$v.application_status_id.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.application_status_id.$error,
                  'is-valid': !$v.application_status_id.$invalid
                }"
              >
                <option
                  v-for="(status, index) in allStatus"
                  v-if="status.id != 3 && status.id != 5"
                  :value="status.id"
                  :key="index"
                >
                  {{ status.name }}
                </option>
              </select>

              <div class="valid-feedback">
                your application_status is valid !
              </div>

              <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.application_status_id.required">
                  Your application_status is required .
                </span>
              </div>
            </div>
            <div class="form-group" v-if="role!=='user'">
              <label for="">Suppliers</label>

              <select

                v-model.trim="$v.supplier_id.$model"
                :class="{
                'form-control': true,
                'is-invalid': $v.supplier_id.$error,
                'is-valid': !$v.supplier_id.$invalid
              }"
              >
                <option
                  v-for="(supplier, index) in suppliers"
                  :selected="supplier.id==supplier_id"
                  :value="supplier.id"
                  :key="index"
                >
                  {{ supplier.company_name }}
                </option>
              </select>
              <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.supplier_id.required">
                  Your Supplier is required .
                </span>
              </div>
              <div class="valid-feedback">
                Supplier is valid !
              </div>

            </div>
            <div role="group" class="form-group">
              <label class=""> Contract Type </label>

              <select
                v-model.trim="$v.contract_type.$model"
                :class="{
                  'form-control': true,
                  'is-invalid': $v.contract_type.$error,
                  'is-valid': !$v.contract_type.$invalid
                }"
              >
                <option value="Full Time"> Full Time </option>
                <option value="FreeLance"> FreeLance </option>
              </select>
              <div class="valid-feedback">
                your contract_type is valid !
              </div>

              <div class="invalid-feedback">
                <span class="d-block" v-if="!$v.contract_type.required">
                  Your contract_type is required .
                </span>
              </div>
            </div>
            <CButton color="primary" @click="store()">Save</CButton>
            <CButton color="primary" @click="goBack">Back</CButton>
          </CCardBody>
        </CCard>
      </CCol>
    </CRow>
  </form>
</template>

<script>
import axios from "axios";
import {
  between,
  email,
  maxLength,
  minLength,
  minValue,
  numeric,
  required
} from "vuelidate/lib/validators";
export default {
  name: "Creat",
  data: () => {
    return {

      nationalities_ar: [
        "أفغاني",
        "الألبانية",
        "جزائري",
        "أمريكي",
        "أندورا",
        "الأنغولي",
        "أنتيجوان",
        "أرجنتيني",
        "أرميني",
        "أسترالي",
        "النمساوي",
        "أذربيجاني",
        "الباهاما",
        "بحريني",
        "بنجلاديشية",
        "باربادوسي",
        "باربودانز",
        "باتسوانا",
        "بيلاروسية",
        "بلجيكي",
        "بليز",
        "بنين",
        "بوتاني",
        "بوليفي",
        "بوسني",
        "برازيلي",
        "بريطاني",
        "بروناي",
        "البلغارية",
        "بوركينا فاسو",
        "بورمي",
        "بوروندي",
        "كمبودي",
        "كاميروني",
        "كندي",
        "الرأس الأخضر",
        "أفريقيا الوسطى",
        "تشادي",
        "تشيلي",
        "صينى",
        "كولومبي",
        "كمرونى",
        "كونغوليون",
        "كوستاريكا",
        "كرواتي",
        "الكوبي",
        "قبرصي",
        "التشيكية",
        "دانماركي",
        "جيبوتي",
        "الدومينيكان",
        "اللغة الهولندية",
        "التيموريون الشرقيون",
        "إكوادوري",
        "مصرية",
        "أميري",
        "غينيا الاستوائية",
        "إريتري",
        "الإستونية",
        "إثيوبي",
        "فيجي",
        "الفلبينية",
        "فنلندية",
        "الفرنسية",
        "الجابونيين",
        "غامبي",
        "الجورجية",
        "ألمانية",
        "غاني",
        "اليونانية",
        "غرينادية",
        "غواتيمالية",
        "غينيا بيساوان",
        "غينيا",
        "جوياني",
        "الهايتي",
        "هيرزيغوفينيان",
        "هندوراس",
        "مجري",
        "آي كيريباتي",
        "آيسلندي",
        "هندي",
        "إندونيسي",
        "إيراني",
        "عراقي",
        "إيرلندي",
        "إسرائيلي",
        "إيطالي",
        "ساحل العاج",
        "جامايكي",
        "اليابانية",
        "أردني",
        "الكازاخستاني",
        "كيني",
        "كيتيان ونيفيسيان",
        "كويتي",
        "قيرغيزستان",
        "اللاوسي",
        "لاتفيا",
        "لبناني",
        "ليبيري",
        "ليبي",
        "ليختنشتاينر",
        "ليتواني",
        "لوكسمبورجر",
        "المقدونية",
        "مدغشقر",
        "ملاوي",
        "ماليزي",
        "مالديفان",
        "مالي",
        "المالطية",
        "مارشال",
        "موريتاني",
        "موريشيوسية",
        "مكسيكي",
        "ميكرونيزية",
        "مولدوفا",
        "موناكان",
        "المنغولية",
        "مغربي",
        "موسوثو",
        "Motswana",
        "موزمبيقى",
        "الناميبي",
        "ناورو",
        "نيبالي",
        "نيوزيلندي",
        "نيكاراغوا",
        "نيجيري",
        "النيجر",
        "كوري شمالي",
        "شمالية إيرلندية",
        "النرويجية",
        "عماني",
        "باكستاني",
        "بالاوان",
        "بنمي",
        "بابوا غينيا الجديدة",
        "باراجواي",
        "بيرو",
        "تلميع",
        "البرتغالية",
        " قطري",
        "روماني",
        "الروسية",
        "رواندي",
        "سانت لوسيان",
        "سلفادورية",
        "ساموا",
        "سان مارينيز",
        "ساو توميان",
        "سعودي",
        "اسكتلندي",
        "سنغالي",
        "الصربية",
        "سيشيل",
        "سيراليوني",
        "سنغافوري",
        "السلوفاكية",
        "سلوفينية",
        "جزر سليمان",
        "صومالي",
        "جنوب افريقيا",
        "كوريا الجنوبية",
        "الأسبانية",
        "سري لانكا",
        "سوداني",
        "سورينامير",
        "سوازي",
        "السويدية",
        "سويسري",
        "سوري",
        "تايواني",
        "طاجيكي",
        "التنزانية",
        "التايلاندية",
        "توغو",
        "تونجا",
        "ترينيداد / توباغونيان",
        "تونسي",
        "اللغة التركية",
        "توفالوان",
        "أوغندي",
        "الأوكرانية",
        "أوروغواي",
        "أوزبكستان",
        "فنزويلية",
        "فيتنامي",
        "ويلزى",
        "يمني",
        "زامبي",
        "زيمبابوي"
      ],

      nationalities: [
        "Afghan",
        "Albanian",
        "Algerian",
        "American",
        "Andorran",
        "Angolan",
        "Antiguans",
        "Argentinean",
        "Armenian",
        "Australian",
        "Austrian",
        "Azerbaijani",
        "Bahamian",
        "Bahraini",
        "Bangladeshi",
        "Barbadian",
        "Barbudans",
        "Batswana",
        "Belarusian",
        "Belgian",
        "Belizean",
        "Beninese",
        "Bhutanese",
        "Bolivian",
        "Bosnian",
        "Brazilian",
        "British",
        "Bruneian",
        "Bulgarian",
        "Burkinabe",
        "Burmese",
        "Burundian",
        "Cambodian",
        "Cameroonian",
        "Canadian",
        "Cape Verdean",
        "Central African",
        "Chadian",
        "Chilean",
        "Chinese",
        "Colombian",
        "Comoran",
        "Congolese",
        "Costa Rican",
        "Croatian",
        "Cuban",
        "Cypriot",
        "Czech",
        "Danish",
        "Djibouti",
        "Dominican",
        "Dutch",
        "East Timorese",
        "Ecuadorean",
        "Egyptian",
        "Emirian",
        "Equatorial Guinean",
        "Eritrean",
        "Estonian",
        "Ethiopian",
        "Fijian",
        "Filipino",
        "Finnish",
        "French",
        "Gabonese",
        "Gambian",
        "Georgian",
        "German",
        "Ghanaian",
        "Greek",
        "Grenadian",
        "Guatemalan",
        "Guinea-Bissauan",
        "Guinean",
        "Guyanese",
        "Haitian",
        "Herzegovinian",
        "Honduran",
        "Hungarian",
        "I-Kiribati",
        "Icelander",
        "Indian",
        "Indonesian",
        "Iranian",
        "Iraqi",
        "Irish",
        "palestine",
        "Italian",
        "Ivorian",
        "Jamaican",
        "Japanese",
        "Jordanian",
        "Kazakhstani",
        "Kenyan",
        "Kittian and Nevisian",
        "Kuwaiti",
        "Kyrgyz",
        "Laotian",
        "Latvian",
        "Lebanese",
        "Liberian",
        "Libyan",
        "Liechtensteiner",
        "Lithuanian",
        "Luxembourger",
        "Macedonian",
        "Malagasy",
        "Malawian",
        "Malaysian",
        "Maldivan",
        "Malian",
        "Maltese",
        "Marshallese",
        "Mauritanian",
        "Mauritian",
        "Mexican",
        "Micronesian",
        "Moldovan",
        "Monacan",
        "Mongolian",
        "Moroccan",
        "Mosotho",
        "Motswana",
        "Mozambican",
        "Namibian",
        "Nauruan",
        "Nepalese",
        "New Zealander",
        "Nicaraguan",
        "Nigerian",
        "Nigerien",
        "North Korean",
        "Northern Irish",
        "Norwegian",
        "Omani",
        "Pakistani",
        "Palauan",
        "Panamanian",
        "Papua New Guinean",
        "Paraguayan",
        "Peruvian",
        "Polish",
        "Portuguese",
        "Qatari",
        "Romanian",
        "Russian",
        "Rwandan",
        "Saint Lucian",
        "Salvadoran",
        "Samoan",
        "San Marinese",
        "Sao Tomean",
        "Saudi",
        "Scottish",
        "Senegalese",
        "Serbian",
        "Seychellois",
        "Sierra Leonean",
        "Singaporean",
        "Slovakian",
        "Slovenian",
        "Solomon Islander",
        "Somali",
        "South African",
        "South Korean",
        "Spanish",
        "Sri Lankan",
        "Sudanese",
        "Surinamer",
        "Swazi",
        "Swedish",
        "Swiss",
        "Syrian",
        "Taiwanese",
        "Tajik",
        "Tanzanian",
        "Thai",
        "Togolese",
        "Tongan",
        "Trinidadian/Tobagonian",
        "Tunisian",
        "Turkish",
        "Tuvaluan",
        "Ugandan",
        "Ukrainian",
        "Uruguayan",
        "Uzbekistani",
        "Venezuelan",
        "Vietnamese",
        "Welsh",
        "Yemenite",
        "Zambian",
        "Zimbabwean"
      ],
      submitstatus: null,

      countries:{},
      allStatus: {},

      name: "",
      mobile: "",
      identity: "",
      nationality: "",
      country: "",
      city: "",
      cities: {},
      gender: "",
      password: "",
      supplier_id: "",
      suppliers: {},
      uuid: "",
      application_status_id: "",
      age: "",
      role: "",
      bank_name: "",
      vehicle_type: "",
      nationalityId: "",
      contract_type: "",
      theAge: "",
      bank_iban: "",
      imageIndex: null,
      showMessage: false,
      message: "",
      alertColor: "",
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  validations: {
    supplier_id:{
      required
    },
    name: {
      required,
      // minLength: minLength(14),
      // maxLength: maxLength(40)
    },
    mobile: {
      required,
      numeric,
      minLength: minLength(10),
      maxLength: maxLength(10),
      isStartWith(value) {
        if (value === "") return true;
        return new Promise(resolve => {
          resolve(value.startsWith("05"));
        });
      },
      isUnique(value) {
        if (value === "") return true;

        return new Promise(resolve => {
          let formData = new FormData();
          formData.append("mobile", value);
          axios
            .post(
              "/api/check-phone?token=" + localStorage.getItem("api_token"),
              formData
            )
            .then(function(response) {
              resolve(response.data);
            });
        });
      }
    },
    nationalityId: {
      required,
      numeric,
      minLength: minLength(10),
      maxLength: maxLength(20),
      isStartWith(value) {
        if (value === "") return true;
        return new Promise(resolve => {
          let valid = value.startsWith("1") || value.startsWith("2");
          resolve(valid);
        });
      }
    },
    identity: {
      required,
      numeric,
      minLength: minLength(10),
      maxLength: maxLength(20)
    },
    bank_name: {
      required,
    },
    bank_iban: {
      required,
      minLength: minLength(24),
      isStartWith(value) {
        if (value === "") return true;
        return new Promise(resolve => {
          let valid = value.startsWith("SA");
          resolve(valid);
        });
      }
    },
    age: {
      required,
      numeric,
      checkAge(value) {
        self = this;
        if (value === "") return true;
        return new Promise(resolve => {
          let currentDate = new Date();
          let year = currentDate.getFullYear();
          let month = currentDate.getMonth();
          let day = currentDate.getDate();
          let theDate = month + "/" + day + "/" + year;
          const date1 = new Date(theDate);
          const date2 = new Date(value);
          const diffTime = Math.abs(date2 - date1);
          const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
          const diffYears = diffDays / 365;
          self.theAge = Math.round(diffYears);

          let valid;

          if (diffYears >= 18) {
            valid = true;
          } else {
            valid = false;
          }

          resolve(valid);
        });
      }
    },

    email: {
      required,
      email
    },
    password: {
      required,
      minLength: minLength(8)
    },
    vehicle_type: {
      required
    },
    application_status_id: {
      required
    },

    contract_type: {
      required
    },
    nationality: {
      required
    },
    country: {
      required
    },
    city: {
      required
    },
    gender: {
      required
    }
  },

  methods: {
    submitForm() {
         this.$v.$touch()

    },
    onlyText(event) {
      let regex = /[^a-z]/gi;
      var Key = event.keyCode
        ? event.keyCode
        : event.which
        ? event.which
        : event.charCode;
      if (Key == 13 || (Key >= 48 && Key <= 57)) {
        event.target.value = event.target.value.replace(regex, "");
      }
    },
    onlyNumber(event) {
      let regex = /[^0-9]/gi;
      var Key = event.keyCode
        ? event.keyCode
        : event.which
        ? event.which
        : event.charCode;
      if (Key == 13 || (Key >= 48 && Key <= 57)) {
      } else {
        event.target.value = event.target.value.replace(regex, "");
      }
    },
    goBack() {
      this.$router.go(-1);
      this.$router.replace({ path: "/driver-applications" });
    },
    store() {
        this.$v.$touch()
      let self = this;
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("mobile", this.mobile);
      formData.append("identity", this.identity);
      formData.append("password", this.password);
      formData.append("age", this.age);
      formData.append("uuid", this.uuid);
      formData.append("bank_name", this.bank_name);
      formData.append("vehicle_type", this.vehicle_type);
      formData.append("country", this.country);
      formData.append("city", this.city);
      formData.append("gender", this.gender);
      formData.append("nationalityId", this.nationalityId);
      formData.append("supplier_id", this.supplier_id);
      formData.append("nationality", this.nationality);
      formData.append("contract_type", this.contract_type);
      formData.append("bank_iban", this.bank_iban);
      formData.append("application_status_id", this.application_status_id);
      axios
        .post(
          "/api/driver-applications" +
            "?token=" +
            localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function(response) {
          self.alertColor = "success";
          self.message = "Successfully Created Fleet.";
          self.showAlert();
          self.goBack();
        })
        .catch(function(error) {
          console.log(error);
          self.alertColor = "danger";
          self.message = "unexpected error occurred in creating new fleet.";
          self.showAlert();
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },

    getFleets() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/driver-applications/create" +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);
          self.allStatus = response.data.status;
          self.suppliers = response.data.suppliers;
          self.countries = response.data.countries;
          self.role = response.data.user.menuroles;
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
          self.loading = false;
          self.alertColor = "danger";
          self.message = "unexpected error occurred in getting fleets.";
          self.showAlert();
        });
    },
    getCity() {
      this.loading = true;
      let self = this;
      this.items = [];
      axios
        .get(
          "/api/cities/"+this.country+
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          console.log(response);
          self.cities = response.data.cities;
          console.log( self.cities );
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    generateUuid() {
      let serialList =
        "123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
      let serialLength = 64;
      let randomSerial = "";

      for (let x = 0; x < serialLength; x++) {
        let randomNum = Math.floor(Math.random() * serialList.length);

        randomSerial += serialList.substring(randomNum, randomNum + 1);
      }
      this.uuid = randomSerial;
    },
    getLocale() {
      let locale;
      locale = localStorage.getItem("locale") || "en";
      this.myLang = locale;
    }
  },

  mounted: function() {
    this.generateUuid();

    this.getLocale();
    this.getFleets();
  }
};
</script>
