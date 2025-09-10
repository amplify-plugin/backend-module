<template>
  <div>
    <!--STEP 02-->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5"
      id="evaporator_coils_two">
      <div class="col-md-6">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(2) ? 'text-success' : 'text-black-50']"
            class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600"
            :class="[$parent.completedSection.includes(2) ? 'text-success' : 'text-danger']">Step 2</h5>
        </div>
        <div class="border rounded-md d-flex align-items-center justify-content-between p-3">
          <div class="fw-500">COIL IS COATED: <span class="text-danger">*</span></div>
          <div class="d-flex gap-3">
            <div class="form-check">
              <input v-model="$parent.coilItems.coil_is_coated" :disabled="!$parent.completedSection.includes(1)"
                @click="$parent.coilVal" value="yes" class="form-check-input custom-radio-color" type="radio"
                name="step-" id="step-1">
              <label class="form-check-label" for="step-1">Yes</label>
            </div>
            <div class="form-check">
              <input v-model="$parent.coilItems.coil_is_coated" :disabled="!$parent.completedSection.includes(1)"
                @click="$parent.coilVal" value="no" class="form-check-input custom-radio-color" type="radio"
                name="step-" id="step-2">
              <label class="form-check-label" for="step-2">No</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--STEP 03-->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5"
      id="evaporator_coils_three">
      <div class="col-md-6">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(3) ? 'text-success' : 'text-black-50']"
            class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600"
            :class="[$parent.completedSection.includes(3) ? 'text-success' : 'text-danger']">Step 3</h5>
        </div>
        <div class="border rounded-md d-flex align-items-center justify-content-between p-3">
          <div>
            <div class="fw-500">COPPER TUBE O.D:</div>
            <div>O.D =Out side dimensions</div>
          </div>
          <select class="form-select form-control w-90" aria-label="Default select example"
            :disabled="!$parent.completedSection.includes(2)" v-model="$parent.coilItems.copper_tube">
            <option value="3/8">3/8</option>
            <option value="1/2">1/2</option>
            <option value="5/8">5/8</option>
          </select>
          <!-- <input :disabled="!$parent.completedSection.includes(2)" v-model="$parent.coilItems.copper_tube" type="text"
            placeholder="0" class="form-control w-90"> -->
        </div>
      </div>
    </div>

    <!--STEP 04-->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5"
      id="evaporator_coils_four">
      <div class="col-md-6">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(4) ? 'text-success' : 'text-black-50']"
            class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600"
            :class="[$parent.completedSection.includes(4) ? 'text-success' : 'text-danger']">Step 4</h5>
        </div>
        <div class="border rounded-md d-flex align-items-center justify-content-between p-3">
          <div>
            <div class="fw-500">NUMBER OF FINS PER INCH</div>
            <div>(6 To 7 Per Inch is Typical)</div>
          </div>

          <select class="form-select form-control w-90" aria-label="Default select example"
            :disabled="!$parent.completedSection.includes(3)" v-model="$parent.coilItems.number_of_fins_per_inc">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
          </select>
          <!-- <input :disabled="!$parent.completedSection.includes(3)" v-model="$parent.coilItems.number_of_fins_per_inc"
            type="text" placeholder="0" class="form-control w-90"> -->
        </div>
      </div>
    </div>

    <!--STEP 05-->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5"
      id="evaporator_coils_five">
      <div class="col-md-6">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(5) ? 'text-success' : 'text-black-50']"
            class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600"
            :class="[$parent.completedSection.includes(5) ? 'text-success' : 'text-danger']">Step 5</h5>
        </div>
        <div class="border rounded-md p-3">
          <div class="d-flex align-items-center mb-3 gap-3">
            <img width="100" src="../../images/evaporator-coils/p1-step-5.png" alt="">
            <div>
              VIEW COIL END TO DETERMINE # OF TUBES THIS EXAMPLE HAS 30 TUBES
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="fw-500">SELECT TOTAL NUMBER OF TUBES ON COIL END</div>
            </div>

            <select class="form-select form-control w-90" aria-label="Default select example"
              :disabled="!$parent.completedSection.includes(4)" v-model="$parent.coilItems.number_of_tubes">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
              <option value="32">32</option>
              <option value="33">33</option>
              <option value="34">34</option>
              <option value="35">35</option>
              <option value="36">36</option>
              <option value="37">37</option>
              <option value="38">38</option>
              <option value="39">39</option>
              <option value="40">40</option>
              <option value="41">41</option>
              <option value="42">42</option>
              <option value="43">43</option>
              <option value="44">44</option>
              <option value="45">45</option>
              <option value="46">46</option>
              <option value="47">47</option>
              <option value="48">48</option>
              <option value="49">49</option>
              <option value="50">50</option>
              <option value="51">51</option>
              <option value="52">52</option>
              <option value="53">53</option>
              <option value="54">54</option>
              <option value="55">55</option>
              <option value="56">56</option>
              <option value="57">57</option>
              <option value="58">58</option>
              <option value="59">59</option>
              <option value="60">60</option>
              <option value="61">61</option>
              <option value="62">62</option>
              <option value="63">63</option>
              <option value="64">64</option>
              <option value="65">65</option>
              <option value="66">66</option>
              <option value="67">67</option>
              <option value="68">68</option>
              <option value="69">69</option>
              <option value="70">70</option>
              <option value="71">71</option>
              <option value="72">72</option>
              <option value="73">73</option>
              <option value="74">74</option>
              <option value="75">75</option>
              <option value="76">76</option>
              <option value="77">77</option>
              <option value="78">78</option>
              <option value="79">79</option>
              <option value="80">80</option>
            </select>
<!-- 
            <input :disabled="!$parent.completedSection.includes(4)" v-model="$parent.coilItems.number_of_tubes"
              type="text" placeholder="0" class="form-control w-90"> -->
          </div>
        </div>

      </div>
    </div>

    <!--STEP 06-->
    <div :class="orderStep === 2 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5"
      id="evaporator_coils_six">
      <div class="col-md-6">
        <div class="title mb-3 d-flex align-items-center gap-2">
          <i :class="[$parent.completedSection.includes(6) ? 'text-success' : 'text-black-50']"
            class="icon-circle-check"></i>
          <h5 class="mb-0 text-uppercase fw-600"
            :class="[$parent.completedSection.includes(6) ? 'text-success' : 'text-danger']">Step 6</h5>
        </div>
        <div class="border rounded-md d-flex align-items-center justify-content-between p-3">
          <div>
            <div class="fw-500">QUANTITY:</div>
          </div>
          <input :disabled="!$parent.completedSection.includes(5)" v-model="$parent.coilItems.qty" type="text"
            placeholder="0" class="form-control w-90">
        </div>

      </div>
    </div>

  </div>
</template>
<script>
export default {
  name: 'step-2-6',
  props: ['orderStep', 'stepTwo', 'stepOneValue', 'stepThree', 'stepFour', 'stepFive', 'stepSix'],
}
</script>