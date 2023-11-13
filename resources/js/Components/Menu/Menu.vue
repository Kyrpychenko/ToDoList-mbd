<script setup lang="ts">
import { sortOptions, toggleFilter, toggleSort, searchValue, filterOptions } from '@/Components/Menu/menu';
import Search from 'custom-mbd-components/src/components/SexyInputs/Search.vue';
</script>
<template>
    <div class="d-flex justify-content-center align-items-center sticky-top">
        <div class="d-flex justify-content-between align-items-center w-100">
            <Search v-model="searchValue" :placeholder="'Suche'"></Search>
            <div class="mt-3">
                <span class="me-2">Filter:</span>
                <!-- <button class="badge rounded-pill bg-secondary text-white me-1" @click="toggleFilter('inWork')">
                        in Arbeit
                        <i v-if="filterOptions !== 'inWork'" class="bi bi-plus-circle"></i>
                        <i v-else class="bi bi-dash-circle"></i>
                    </button> -->
                <div class="btn-group me-2" role="group">
                    <input
                        type="radio"
                        class="btn-check"
                        name="btnradio"
                        id="btnradio1"
                        autocomplete="off"
                        @click="toggleFilter('unfinished')"
                        :checked="filterOptions == 'unfinished'"
                    />
                    <label class="btn btn-outline-secondary" for="btnradio1">Nicht angefangen</label>
                    <input
                        type="radio"
                        class="btn-check"
                        name="btnradio"
                        id="btnradio2"
                        autocomplete="off"
                        @click="toggleFilter('finished')"
                        :checked="filterOptions == 'finished'"
                    />
                    <label class="btn btn-outline-secondary" for="btnradio2">Abgeschlossen</label>
                    <input
                        type="radio"
                        class="btn-check"
                        name="btnradio"
                        id="btnradio3"
                        autocomplete="off"
                        @click="toggleFilter('createdBy')"
                        :checked="filterOptions == 'createdBy'"
                    />
                    <label class="btn btn-outline-secondary" for="btnradio3">Von dir erstellt</label>
                </div>
                <span class="me-2">Sortieren:</span>
                <div class="btn-group position-relative" role="group">
                    <button class="btn btn-secondary text-white me-1" @click="toggleSort('deadlineUp')" v-if="sortOptions !== 'deadlineUp'">
                        Deadline
                        <i class="bi bi-arrow-up"></i>
                    </button>
                    <button class="btn btn-secondary text-white me-1" @click="toggleSort('deadlineDown')" v-else>
                        Deadline
                        <i class="bi bi-arrow-down"></i>
                    </button>
                    <i
                        class="x-wrapper bi bi-x-circle-fill text-danger d-flex justify-content-center align-items-center position-absolute"
                        @click="toggleSort(null)"
                        v-if="sortOptions !== null"
                        role="button"
                    ></i>
                    <div
                        class="position-absolute bg-light d-flex justify-content-center align-items-center"
                        style="top: -3px; right: -3px; height: 16px; width: 16px; border-radius: 50%; z-index: 999"
                        v-if="sortOptions !== null"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.x-wrapper {
    border-radius: 50%;
    right: -10px;
    top: -10px;
    z-index: 1000;
    height: 32px;
    width: 32px;
}
</style>
