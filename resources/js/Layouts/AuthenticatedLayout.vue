<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

defineProps({
    user: {
        type: Object,
        required: true,
    },
});

// アコーディオン開閉用の変数と関数
const isOpen = ref(false);
const toggleAccordion = () => {
    isOpen.value = !isOpen.value;
};

// ページ読み込み時にURLのパスをチェックして、/member以下の場合はアコーディオンを開く
onMounted(() => {
    if (window.location.pathname.startsWith("/member")) {
        isOpen.value = true;
    }
});
</script>

<template>
    <div>
        <div>
            <!-- Navigation Toggle -->
            <button
                type="button"
                class="text-gray-500 hover:text-gray-600"
                data-hs-overlay="#docs-sidebar"
                aria-controls="docs-sidebar"
                aria-label="Toggle navigation"
            >
                <span class="sr-only">Toggle Navigation</span>
                <svg
                    class="flex-shrink-0 size-4"
                    width="16"
                    height="16"
                    fill="currentColor"
                    viewBox="0 0 16 16"
                >
                    <path
                        fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
                    />
                </svg>
            </button>
            <!-- End Navigation Toggle -->

            <!-- Sidebar｜PCサイズの場合に表示 -->
            <div
                id="docs-sidebar"
                class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500 dark:bg-gray-800 dark:border-gray-700"
            >
                <div class="px-6">
                    <a
                        class="flex-none text-xl font-semibold dark:text-white"
                        href="#"
                        >{{ user.name }}</a
                    >
                </div>
                <nav
                    class="hs-accordion-group p-6 w-full flex flex-col flex-wrap"
                    data-hs-accordion-always-open
                >
                    <ul class="space-y-1.5">
                        <li class="hs-accordion" id="users-accordion">
                            <button
                                type="button"
                                @click="toggleAccordion"
                                class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                            >
                                <svg
                                    class="size-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                    />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                会員情報

                                <svg
                                    class="hs-accordion-active:block ms-auto hidden size-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="m18 15-6-6-6 6" />
                                </svg>

                                <svg
                                    class="hs-accordion-active:hidden ms-auto block size-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                                    width="16"
                                    height="16"
                                    viewBox="0 0 16 16"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                    ></path>
                                </svg>
                            </button>

                            <div
                                id="users-accordion"
                                class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                v-show="isOpen"
                            >
                                <ul
                                    class="hs-accordion-group ps-3 pt-2"
                                    data-hs-accordion-always-open
                                >
                                    <li
                                        class="hs-accordion"
                                        id="users-accordion-sub-1"
                                    >
                                        <Link
                                            href="/members"
                                            class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                        >
                                            会員情報一覧
                                        </Link>
                                    </li>

                                    <li
                                        class="hs-accordion"
                                        id="users-accordion-sub-1"
                                    >
                                        <Link
                                            href="/members/create"
                                            class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                        >
                                            会員情報登録
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div>
            <slot></slot>
        </div>
    </div>
</template>
