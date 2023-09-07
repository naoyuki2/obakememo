<template>
    <main>
        <header>
            <div class="px-3 py-2 bg-dark text-white">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <div class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                            <div class="date-display text-white">
                                今日の日付は {{ currentDate }} です
                            </div>
                        </div>

                        <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                            <li class="Home">
                                <div class="nav-link text-secondary">
                                    <router-link to="/" style="color: rgb(255, 255, 255);">
                                    <img src="@/assets/img/Home.png" class="bi d-block mx-auto mb-1" width="45" height="30">ホーム
                                    </router-link>
                                </div>
                            </li>
                            <li class="Grave">
                                <div class="nav-link text-white">
                                    <router-link to="/GravePage" style="color: rgb(255, 255, 255);">
                                    <img src="@/assets/img/Grave.png" class="bi d-block mx-auto mb-1" width="45" height="30">墓
                                    </router-link>
                                </div>
                            </li>
                            <li class="Calendar">
                                <div class="nav-link text-white">
                                    <router-link to="CalendarPage" style="color: rgb(255, 255, 255);">
                                    <img src="@/assets/img/Calendar.png" class="bi d-block mx-auto mb-1" width="45" height="30">カレンダー
                                    </router-link>
                                </div>
                            </li>
                            <li class="Ghost">
                                <div class="nav-link text-white">
                                    <router-link to="GhostPage" style="color: rgb(255, 255, 255);">
                                    <img src="@/assets/img/Ghost.png" class="bi d-block mx-auto mb-1" width="45" height="30">通知欄
                                    </router-link>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
    </main>
</template>

<script>
export default {
    data() {
        return {
            currentDate: "",
        };
    },
    mounted() {
        this.getCurrentDate();
    },
    methods: {
        getCurrentDate() {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            this.currentDate = now.toLocaleDateString('ja-JP', options);
        },
    },
};
</script>