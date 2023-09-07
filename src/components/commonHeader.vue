<template>
    <main>
        <header>
            <div class="px-3 py-2 bg-dark text-white">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <div class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                            <img src="" class="bi me-2" width="160" height="80"
                                role="img" aria-label="Bootstrap" alt="アイコン">
                        </div>

                        <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                            <li class="Home">
                                <div class="nav-link text-secondary">
                                    <img src="@/assets/img/Home.png" class="bi d-block mx-auto mb-1" width="45" height="30">
                                    <router-link to="/">ホーム</router-link>
                                </div>
                            </li>
                            <li class="Grave">
                                <div class="nav-link text-white">
                                    <img src="@/assets/img/Grave.png" class="bi d-block mx-auto mb-1" width="45" height="30">
                                    <router-link to="/GravePage">墓</router-link>
                                </div>
                            </li>
                            <li class="Calendar">
                                <div class="nav-link text-white">
                                    <img src="@/assets/img/Calendar.png" class="bi d-block mx-auto mb-1" width="45" height="30">
                                    <router-link to="CalendarPage">カレンダー</router-link>
                                </div>
                            </li>
                            <li class="Ghost">
                                <div class="nav-link text-white">
                                    <img src="@/assets/img/Ghost.png" class="bi d-block mx-auto mb-1" width="45" height="30">
                                    <router-link to="GhostPage">通知欄</router-link>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
    </main>
</template>