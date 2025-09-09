<template>
  <div class="input-popover popover fade show bs-popover-left notification_popover" role="tooltip">
    <div class="arrow" style="top: 34px;"></div>

    <div class="list-group">
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <p class="mb-1">Custom heaters with at least a 60"" <u>configuration length</u> have the option to save on freight charges.</p>
    <small class="text-muted">(NOTE: <i>Configuration length is NOT the total straight length.</i>)</small>
  </a>
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <p class="mb-1">RHS can roll the length of the heater to reduce higher shipping charges.<br>
      Once received, your rolled heater can be gently unrolled with a rubber mallet. </p>
    <small class="text-muted">(<i>In the winter months, allow
      heater to reach room temperature before unrolling.</i>)</small>
  </a>

  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <p class="mb-1">If you want to roll your heater to save on shipping please select YES.<br>
      If you do NOT want your heater rolled, select NO, but Motor Freight charges may apply!</p>
    <small class="text-muted">(<i>Motor Freight charges can range from an extra $150 to $250.</i>)</small>
  </a>
</div>
  </div>

</template>
<script>

export default {
  name: 'Notification Modal',
}
</script>
<style>
.notification_popover {
  top: 75%;
  left: 75%;
  display: block;
  width: 100%;
  max-width: 50%;
  /* padding: 3%; */
  border: 1px solid;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.notification_popover .arrow {
  left: 36%;
  top: -5% !important;
  transform: rotate(270deg);
}
</style>