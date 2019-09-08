<template>
    <div class="building-types-marker">
        <div class="row d-inline-flex no-gutters pl-1 pr-0 pb-2 pt-2">
            <div class="col pr-1" v-for="(buildingType,i) in allBuildingTypes" :key="i">
                <span
                    class="text-white pr-2 pl-2 pt-1 pb-1 text-uppercase"
                    :class="['bg-' + buildingType.bg]"
                >{{ buildingType.short }}</span>
            </div>
        </div>
    </div>
</template>

<style>
.building-types-marker {
    position: absolute;
    z-index: 1;
    top: 0.2rem;
    left: 60%;
}
.building-types-marker > div.row {
    background-color: #060606;
}
</style>

<script>
export default {
  name: 'BuildingTypesMarkers',
  computed: {
    allBuildingTypes() {
      return this.$store.state.buildingTypes;
    },
  },
};
</script>
