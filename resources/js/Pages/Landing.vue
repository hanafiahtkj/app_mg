<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import { ref, reactive, onMounted, computed } from "vue";
import accounting from "accounting";
import CurrencyInput from "@/Components/CurrencyInput.vue";

const page = usePage();

const props = defineProps({
    referallCount: Number,
    balance: Number,
    earning: Number,
    income: Number,
    withdraw: Number,
    level: {
        type: Object,
    },
    coinsMarkets: {
        type: Object,
    },
});

// const coinsMarkets = ref([]);

const loadCoinsMarkets = async () => {
    let url = route("coins.markets");
    const response = await axios.get(url);
    if (response.status === 200) {
        const data = response.data;
        coinsMarkets.value = data;
        console.log(data);
    }
};

const formatCurrency = (value) => {
    const decimalCount = (value.toString().split(".")[1] || "").length;
    return accounting.formatMoney(value, {
        symbol: "", // Tidak menampilkan simbol mata uang
        precision: decimalCount || 0, // Menampilkan 2 angka di belakang koma
        thousand: ",", // Menyusun ribuan dengan titik
        decimal: ".", // Menyusun desimal dengan koma
    });
};

const formatCurrencyCoin = (value) => {
    const decimalCount = (value.toString().split(".")[1] || "").length;
    return accounting.formatMoney(value, {
        symbol: "", // Tidak menampilkan simbol mata uang
        precision: 4, // Menampilkan 2 angka di belakang koma
        thousand: ",", // Menyusun ribuan dengan titik
        decimal: ".", // Menyusun desimal dengan koma
    });
};

let depositActionSheet;
let withdrawActionSheet;

const deposit = useForm({
    amount: 0,
});

const submitDeposit = () => {
    deposit.post(route("transaction.deposit"), {
        onFinish: () => {},
        onSuccess: () => {
            depositActionSheet.hide();
        },
    });
};

const withdraw = useForm({
    amount: 0,
});

const submitWithdraw = () => {
    withdraw.post(route("transaction.withdraw"), {
        onFinish: () => {},
        onSuccess: () => {
            withdrawActionSheet.hide();
        },
    });
};

const loadedImages = ref({});

const handelLoadImage = (index) => {
    loadedImages.value[index] = true;
};

onMounted(() => {
    console.log("balance", props.balance);
    // loadCoinsMarkets();

    const bodyHeight = document.documentElement.scrollHeight;
    const contentWrapper = document.querySelector("#appCapsule");
    contentWrapper.style.minHeight = bodyHeight + "px";

    const imagedElements = document.querySelectorAll(".imaged");
    // const bodyHeight = document.body.clientHeight;

    imagedElements.forEach((imaged) => {
        imaged.style.maxHeight = bodyHeight - 200 + "px";
    });

    // alert(bodyHeight);
    // depositActionSheet = new bootstrap.Modal(
    //     document.getElementById("depositActionSheet")
    // );
    // withdrawActionSheet = new bootstrap.Modal(
    //     document.getElementById("withdrawActionSheet")
    // );

    // Slider Carousel
    document.querySelectorAll(".carousel-slider").forEach((carousel) =>
        new Splide(carousel, {
            perPage: 1,
            rewind: false,
            type: "loop",
            gap: 16,
            padding: 16,
            arrows: false,
            pagination: true,
        }).mount()
    );
});
</script>

<template>
    <Head title="Welcome" />

    <!-- App Header -->
    <!-- <div class="appHeader no-border transparent">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Welcome</div>
        <div class="right"></div>
    </div> -->
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <!-- {{ loadedImages }} -->
        <!-- carousel slider -->
        <div class="carousel-slider splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide p-2">
                        <div class="loading" v-if="loadedImages[1] !== true">
                            <div
                                class="spinner-border"
                                style="width: 3rem; height: 3rem"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img
                            :src="route('index') + '/assets/img/slide/01.webp'"
                            alt="alt"
                            class="imaged w-100 square mb-4"
                            loading="lazy"
                            @load="handelLoadImage(1)"
                        />
                    </li>
                    <li class="splide__slide p-2">
                        <div class="loading" v-if="loadedImages[2] !== true">
                            <div
                                class="spinner-border"
                                style="width: 3rem; height: 3rem"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img
                            :src="route('index') + '/assets/img/slide/02.webp'"
                            alt="alt"
                            class="imaged w-100 square mb-4"
                            loading="lazy"
                            @load="handelLoadImage(2)"
                        />
                    </li>
                    <li class="splide__slide p-2">
                        <h2 class="mb-2">1. Login & Register</h2>
                        <div class="loading" v-if="loadedImages[3] !== true">
                            <div
                                class="spinner-border"
                                style="width: 3rem; height: 3rem"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img
                            :src="
                                route('index') +
                                '/assets/img/slide/1.Loginregister.gif'
                            "
                            alt="alt"
                            class="imaged w-100 square mb-4"
                            loading="lazy"
                            @load="handelLoadImage(3)"
                        />
                    </li>
                    <li class="splide__slide p-2">
                        <h2 class="mb-2">2. Basic Feature</h2>
                        <div class="loading" v-if="loadedImages[4] !== true">
                            <div
                                class="spinner-border"
                                style="width: 3rem; height: 3rem"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img
                            :src="
                                route('index') +
                                '/assets/img/slide/2.BasicFeature.gif'
                            "
                            alt="alt"
                            class="imaged w-100 square mb-4"
                            loading="lazy"
                            @load="handelLoadImage(4)"
                        />
                    </li>

                    <li class="splide__slide p-2">
                        <h2 class="mb-2">3. Deposit</h2>
                        <div class="loading" v-if="loadedImages[5] !== true">
                            <div
                                class="spinner-border"
                                style="width: 3rem; height: 3rem"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img
                            :src="
                                route('index') +
                                '/assets/img/slide/3.Depositpaymentclaim.gif'
                            "
                            alt="alt"
                            class="imaged w-100 square mb-4"
                            loading="lazy"
                            @load="handelLoadImage(5)"
                        />
                    </li>
                    <li class="splide__slide p-2">
                        <h2 class="mb-2">4. Investment</h2>
                        <div class="loading" v-if="loadedImages[6] !== true">
                            <div
                                class="spinner-border"
                                style="width: 3rem; height: 3rem"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img
                            :src="
                                route('index') +
                                '/assets/img/slide/4.Investment.gif'
                            "
                            alt="alt"
                            class="imaged w-100 square mb-4"
                            loading="lazy"
                            @load="handelLoadImage(6)"
                        />
                    </li>
                    <li class="splide__slide p-2">
                        <h2 class="mb-2">5. History and claim</h2>
                        <div class="loading" v-if="loadedImages[7] !== true">
                            <div
                                class="spinner-border"
                                style="width: 3rem; height: 3rem"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img
                            :src="
                                route('index') +
                                '/assets/img/slide/5.Historyandclaim.gif'
                            "
                            alt="alt"
                            class="imaged w-100 square mb-4"
                            loading="lazy"
                            @load="handelLoadImage(7)"
                        />
                    </li>
                    <li class="splide__slide p-2">
                        <h2 class="mb-2">6.Withdraw</h2>
                        <div class="loading" v-if="loadedImages[8] !== true">
                            <div
                                class="spinner-border"
                                style="width: 3rem; height: 3rem"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img
                            :src="
                                route('index') +
                                '/assets/img/slide/6.Withdrawhistorywithdrawal.gif'
                            "
                            alt="alt"
                            class="imaged w-100 square mb-4"
                            loading="lazy"
                            @load="handelLoadImage(8)"
                        />
                    </li>
                </ul>
            </div>
        </div>
        <!-- * carousel slider -->

        <div class="carousel-button-footer">
            <div class="row" style="width: 35rem">
                <div class="col-6">
                    <Link
                        :href="route('register')"
                        class="btn btn-outline-secondary btn-lg btn-block"
                        >Register</Link
                    >
                </div>
                <div class="col-6">
                    <Link
                        :href="route('login')"
                        class="btn btn-warning btn-lg btn-block"
                        >Login</Link
                    >
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
</template>

<style scoped>
.carousel-slider .imaged.w-100 {
    /* max-width: 500px; */
}

.carousel-slider .splide__pagination {
    bottom: 90px !important;
}

#appCapsule {
    padding-top: 20px;
    padding-bottom: 0px;
    background-image: linear-gradient(-208deg, #4a2d02 38%, #8a69ff 100%);
}

.wallet-card .balance {
    height: 80px;
}
.wallet-card-section:before {
    /* background: #3b2402; */
    height: 275px;
    background-image: linear-gradient(-208deg, #4a2d02 38%, #8a69ff 100%);
}
body.dark-mode .wallet-card {
    background: #161129d6;
}
.wallet-card .wallet-footer {
    border-top: 0px;
    padding-top: 0px;
}
.small-box-footer {
    /* background-color: rgba(0,0,0,.1); */
    color: rgba(255, 255, 255, 0.8);
    display: block;
    padding: 3px 0;
    position: relative;
    text-align: right;
    text-decoration: none;
    z-index: 10;
}
.loading {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    /* justify-items: center; */
    text-align: center;
    justify-content: center;
}
</style>
