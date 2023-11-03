<script setup lang="ts">
const filter = 'none';
</script>
<template>
    <div class="d-flex sticky-top" style="height: 0">
        <div>
            <ul class="list-unstyled bg-primary">
                <li>Text goes here</li>
                <li>Text goes here</li>
                <li>Text goes here</li>
                <li>Text goes here</li>
                <li>Text goes here</li>
                <li>Text goes here</li>
                <li>Text goes here</li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.left-menu ul {
    list-style: none;
    padding: 0;
}

.left-menu li {
    cursor: pointer;
    margin-bottom: 10px;
    padding: 10px;
}

.left-menu li:hover {
    text-decoration: underline;
}
</style>
