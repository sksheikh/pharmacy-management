<template>
    <div class="d-flex jc-between ai-center">
        <h2>All Vendors</h2>
        <TheButtonVue>Add new</TheButtonVue>
    </div>

    <!--Table-->
    <table class="mt-4">
        <!--thead-->
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>

        <!--tbody-->
        <tbody>
            <tr v-for="i in 9" :key="i">
                <td>Sheikh</td>
                <td>Lorem ipsum dolor sit amet.</td>
                <td>
                    <img src="/img/edit.png" alt="" class="action-icon">
                    <img src="/img/trash.png" alt="" class="action-icon action-icon--delete ml-3">
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import TheButtonVue from '../../components/TheButton.vue'
export default {
    components: {
        TheButtonVue
    }
}
</script>