<template>
    <div class="card text-center m-3">
        <div class="card-footer pb-0 pt-3">
            <ul v-if="pager.data && pager.data.length" class="pagination">
                <li :class="{'disabled':pager.current_page === 1}" class="page-item first-item">
                    <router-link :to="{ query: { page: 1 }}" class="page-link">First</router-link>
                </li>
                <li :class="{'disabled':pager.current_page === 1}" class="page-item previous-item">
                    <router-link :to="{ query: { page: pager.current_page - 1 }}" class="page-link">Previous</router-link>
                </li>
                <li v-for="page in pager.pages" :key="page" :class="{'active':pager.current_page === page}" class="page-item number-item">
                    <router-link :to="{ query: { page: page }}" class="page-link">{{page}}</router-link>
                </li>
                <li :class="{'disabled':pager.current_page === pager.last_page}" class="page-item next-item">
                    <router-link :to="{ query: { page: pager.current_page + 1 }}" class="page-link">Next</router-link>
                </li>
                <li :class="{'disabled':pager.current_page === pager.last_page}" class="page-item last-item">
                    <router-link :to="{ query: { page: pager.last_page }}" class="page-link">Last</router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
name: 'TwistPagination',
    props: {
    pager: {}
    }
}
</script>