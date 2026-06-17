<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
</head>
{{-- {{ asset('storage/WebsiteImages/home/labelicon.png') }} --}}

<body>
    <div class="w-full h-screen">
        <div class="w-full h-full block sm:flex flex-wrap">
            <div class="flex flex-col items-center pt-12 gap-[110px] min-w-[280px] border-r border-black/20"
                id="dashboardnav-wrapper">
                <div class="mx-auto"><img src={{ asset('storage/images/logo.png') }} alt="company logo"
                        class="max-w-(--max-w-lg) object-contain"></div>
                <nav class="dashboardnav">
                    <ul class="flex flex-col gap-[45px]">
                        <li class="dashboard-list">
                            <a href="#!">
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9 3H4C3.44772 3 3 3.44772 3 4V11C3 11.5523 3.44772 12 4 12H9C9.55228 12 10 11.5523 10 11V4C10 3.44772 9.55228 3 9 3Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M20 3H15C14.4477 3 14 3.44772 14 4V7C14 7.55228 14.4477 8 15 8H20C20.5523 8 21 7.55228 21 7V4C21 3.44772 20.5523 3 20 3Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M20 12H15C14.4477 12 14 12.4477 14 13V20C14 20.5523 14.4477 21 15 21H20C20.5523 21 21 20.5523 21 20V13C21 12.4477 20.5523 12 20 12Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M9 16H4C3.44772 16 3 16.4477 3 17V20C3 20.5523 3.44772 21 4 21H9C9.55228 21 10 20.5523 10 20V17C10 16.4477 9.55228 16 9 16Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="dashboard-list">
                            <a href="#!"><span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 3V9" stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M16.76 2.99999C17.1327 2.99739 17.4988 3.09901 17.8168 3.29338C18.1349 3.48774 18.3923 3.76712 18.56 4.09999L20.79 8.57899C20.9279 8.85576 20.9998 9.16075 21 9.46999V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V9.47199C3.00002 9.16165 3.07226 8.85558 3.211 8.57799L5.45 4.09999C5.61696 3.76864 5.87281 3.49027 6.18893 3.29601C6.50504 3.10175 6.86897 2.99926 7.24 2.99999H16.76Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M3.054 9.013H20.947" stroke="black" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span><span>My products</span></a>
                        </li>
                        <li class="dashboard-list">
                            <a href="#!">
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 10C16 11.0609 15.5786 12.0783 14.8284 12.8284C14.0783 13.5786 13.0609 14 12 14C10.9391 14 9.92172 13.5786 9.17157 12.8284C8.42143 12.0783 8 11.0609 8 10"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M3.103 6.034H20.897" stroke="black" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M3.4 5.467C3.14036 5.81319 3 6.23426 3 6.667V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6.667C21 6.23426 20.8596 5.81319 20.6 5.467L18.6 2.8C18.4137 2.55161 18.1721 2.35 17.8944 2.21115C17.6167 2.07229 17.3105 2 17 2H7C6.68951 2 6.38328 2.07229 6.10557 2.21115C5.82786 2.35 5.58629 2.55161 5.4 2.8L3.4 5.467Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span><span>My orders</span></a>
                        </li>
                        <li class="dashboard-list">
                            <a href="#!"><span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11 15H13C13.5304 15 14.0391 14.7893 14.4142 14.4142C14.7893 14.0391 15 13.5304 15 13C15 12.4696 14.7893 11.9609 14.4142 11.5858C14.0391 11.2107 13.5304 11 13 11H10C9.4 11 8.9 11.2 8.6 11.6L3 17"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M7 21L8.6 19.6C8.9 19.2 9.4 19 10 19H14C15.1 19 16.1 18.6 16.8 17.8L21.4 13.4C21.7859 13.0354 22.0111 12.5323 22.0261 12.0016C22.0411 11.4709 21.8447 10.9559 21.48 10.57C21.1153 10.1841 20.6123 9.95892 20.0816 9.94392C19.5508 9.92891 19.0359 10.1254 18.65 10.49L14.45 14.39"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M2 16L8 22" stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M16 11.9C17.6016 11.9 18.9 10.6016 18.9 8.99998C18.9 7.39835 17.6016 6.09998 16 6.09998C14.3984 6.09998 13.1 7.39835 13.1 8.99998C13.1 10.6016 14.3984 11.9 16 11.9Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M6 8C7.65685 8 9 6.65685 9 5C9 3.34315 7.65685 2 6 2C4.34315 2 3 3.34315 3 5C3 6.65685 4.34315 8 6 8Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>Payout</span></a>
                        </li>
                        <li class="dashboard-list">
                            <a href="#!"><span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3 11H6C6.53043 11 7.03914 11.2107 7.41421 11.5858C7.78929 11.9609 8 12.4696 8 13V16C8 16.5304 7.78929 17.0391 7.41421 17.4142C7.03914 17.7893 6.53043 18 6 18H5C4.46957 18 3.96086 17.7893 3.58579 17.4142C3.21071 17.0391 3 16.5304 3 16V11ZM3 11C3 9.8181 3.23279 8.64778 3.68508 7.55585C4.13738 6.46392 4.80031 5.47177 5.63604 4.63604C6.47177 3.80031 7.46392 3.13738 8.55585 2.68508C9.64778 2.23279 10.8181 2 12 2C13.1819 2 14.3522 2.23279 15.4442 2.68508C16.5361 3.13738 17.5282 3.80031 18.364 4.63604C19.1997 5.47177 19.8626 6.46392 20.3149 7.55585C20.7672 8.64778 21 9.8181 21 11M21 11V16C21 16.5304 20.7893 17.0391 20.4142 17.4142C20.0391 17.7893 19.5304 18 19 18H18C17.4696 18 16.9609 17.7893 16.5858 17.4142C16.2107 17.0391 16 16.5304 16 16V13C16 12.4696 16.2107 11.9609 16.5858 11.5858C16.9609 11.2107 17.4696 11 18 11H21Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M21 16V18C21 19.0609 20.5786 20.0783 19.8284 20.8284C19.0783 21.5786 18.0609 22 17 22H12"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span><span>Support</span></a>
                        </li>
                        <li class="dashboard-list">
                            <a href="#!"><span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.671 4.13603C9.7261 3.55637 9.99533 3.01807 10.4261 2.62631C10.8569 2.23454 11.4182 2.01746 12.0005 2.01746C12.5828 2.01746 13.1441 2.23454 13.5749 2.62631C14.0057 3.01807 14.2749 3.55637 14.33 4.13603C14.3631 4.51048 14.486 4.87145 14.6881 5.18837C14.8903 5.50529 15.1659 5.76884 15.4915 5.95671C15.8171 6.14457 16.1831 6.25123 16.5587 6.26765C16.9343 6.28407 17.3082 6.20977 17.649 6.05103C18.1781 5.81081 18.7777 5.77605 19.331 5.95352C19.8843 6.13098 20.3518 6.50798 20.6425 7.01113C20.9332 7.51429 21.0263 8.1076 20.9036 8.6756C20.781 9.2436 20.4514 9.74565 19.979 10.084C19.6714 10.2999 19.4203 10.5866 19.2469 10.9201C19.0736 11.2535 18.983 11.6237 18.983 11.9995C18.983 12.3753 19.0736 12.7456 19.2469 13.079C19.4203 13.4124 19.6714 13.6992 19.979 13.915C20.4514 14.2534 20.781 14.7555 20.9036 15.3235C21.0263 15.8915 20.9332 16.4848 20.6425 16.9879C20.3518 17.4911 19.8843 17.8681 19.331 18.0455C18.7777 18.223 18.1781 18.1883 17.649 17.948C17.3082 17.7893 16.9343 17.715 16.5587 17.7314C16.1831 17.7478 15.8171 17.8545 15.4915 18.0424C15.1659 18.2302 14.8903 18.4938 14.6881 18.8107C14.486 19.1276 14.3631 19.4886 14.33 19.863C14.2749 20.4427 14.0057 20.981 13.5749 21.3727C13.1441 21.7645 12.5828 21.9816 12.0005 21.9816C11.4182 21.9816 10.8569 21.7645 10.4261 21.3727C9.99533 20.981 9.7261 20.4427 9.671 19.863C9.63794 19.4884 9.5151 19.1273 9.31286 18.8103C9.11063 18.4933 8.83497 18.2296 8.50923 18.0418C8.18349 17.8539 7.81727 17.7472 7.44158 17.7309C7.06589 17.7146 6.6918 17.7891 6.351 17.948C5.82189 18.1883 5.22233 18.223 4.669 18.0455C4.11567 17.8681 3.64817 17.4911 3.35748 16.9879C3.06679 16.4848 2.97371 15.8915 3.09636 15.3235C3.219 14.7555 3.5486 14.2534 4.021 13.915C4.32862 13.6992 4.57973 13.4124 4.75309 13.079C4.92645 12.7456 5.01695 12.3753 5.01695 11.9995C5.01695 11.6237 4.92645 11.2535 4.75309 10.9201C4.57973 10.5866 4.32862 10.2999 4.021 10.084C3.54926 9.74547 3.22025 9.24362 3.0979 8.67601C2.97555 8.1084 3.06861 7.51557 3.35898 7.01274C3.64936 6.50991 4.11631 6.13301 4.66909 5.95527C5.22187 5.77753 5.82098 5.81166 6.35 6.05103C6.69076 6.20977 7.06474 6.28407 7.4403 6.26765C7.81586 6.25123 8.18193 6.14457 8.50754 5.95671C8.83314 5.76884 9.10869 5.50529 9.31086 5.18837C9.51304 4.87145 9.63588 4.51048 9.669 4.13603"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span><span>Settings</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="flex-[unset] sm:flex-1">
                <div
                    class="w-full flex flex-wrap md:flex-nowrap justify-center pt-[35px] px-6 pb-6 md:pl-14 md:pr-9 border-b border-black/20 gap-5">
                    <div
                        class="flex-1 flex-box w-full max-w-full order-2 md:w-auto md:max-w-auto justify-start rounded-[64.18px] border border-black/20 pl-4 pr-2.5 py-4">
                        <span><img src={{ asset('storage/images/dahboard-search.png') }} alt=""
                                class="max-w-[25px] object-contain"></span>
                                <input type="text"
                            class="w-full h-full placeholder:font-sans placeholder:text-xl placeholder:text-black placeholder:font-normal placeholder:tracking-1 placeholder:leading-tight"
                            placeholder="Search">
                    </div>
                    <div class="w-full md:w-auto flex items-center gap-5">
                        <button type="button" class="text-[28px]"> <i
                                class="fa-solid fa-bars block lg:hidden! m-auto" id="dashboardhamburger"></i></button>

                        <button
                            class="w-10 h-10 md:w-[65px] md:h-[65px] ml-auto inline-block mr-0 my-0 md:m-auto group rounded-full border border-black/20 hover:bg-black"><svg
                                width="33" height="33" viewBox="0 0 33 33" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="w-full max-h-6 group-hover:text-white">
                                <path
                                    d="M14.0681 28.7721C14.3086 29.1886 14.6545 29.5345 15.0711 29.775C15.4876 30.0154 15.9601 30.142 16.4411 30.142C16.9221 30.142 17.3946 30.0154 17.8112 29.775C18.2277 29.5345 18.5736 29.1886 18.8141 28.7721"
                                    stroke="currentColor" stroke-width="2.7402" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M4.46917 20.9981C4.29019 21.1943 4.17207 21.4383 4.12919 21.7003C4.08631 21.9624 4.12051 22.2313 4.22763 22.4743C4.33476 22.7173 4.51018 22.9239 4.73258 23.069C4.95497 23.2141 5.21475 23.2915 5.4803 23.2917H27.4019C27.6674 23.2918 27.9272 23.2147 28.1498 23.0699C28.3723 22.925 28.5479 22.7186 28.6554 22.4758C28.7628 22.233 28.7973 21.9642 28.7548 21.7021C28.7122 21.44 28.5944 21.1959 28.4157 20.9995C26.5935 19.1211 24.6617 17.1249 24.6617 10.9608C24.6617 8.78056 23.7956 6.68962 22.2539 5.14796C20.7123 3.6063 18.6213 2.7402 16.4411 2.7402C14.2609 2.7402 12.1699 3.6063 10.6283 5.14796C9.08659 6.68962 8.2205 8.78056 8.2205 10.9608C8.2205 17.1249 6.28729 19.1211 4.46917 20.9981Z"
                                    stroke="currentColor" stroke-width="2.7402" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg></button>
                        <div
                            class="w-10 h-10 md:w-[65px] md:h-[65px] rounded-full border border-black/20 overflow-hidden">
                            <img src={{ asset('storage/images/profileimg.png') }}
                         alt=""
                                class="scale-150">
                        </div>
                        <span>
                            <select name="" id="" class="focus:outline-none">
                                <option value="">Looney</option>
                                <option value="">Looney</option>
                                <option value="">Looney</option>
                                <option value="">Looney</option>
                            </select>
                        </span>

                    </div>
                </div>
                <div class="w-full flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-10">
                    <div class="">
                        <h3 class="font-sans font-normal text-3xl sm:text-[40px] leading-tight tracking-1 text-black">
                            Welcome
                            Looney,</h3>
                        <p class="font-sans font-normal text-lg leading-tight tracking-1 text-black">Let's get your
                            store moving!</p>
                    </div>
                    <button
                        class="w-[145px] h-[45px] sm:w-[180px] sm:h-[62px] rounded-[10px] bg-[#1C1C1C] border-[1.18px] self-start mt-3 md:mt-0 md:self-end border-black/20"><span
                            class="font-sans font-medium text-base leading-tight tracking-1 text-white">Add
                            Listing</span></button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 px-6 md:pl-14 md:pr-9 pb-4">
                    <a href="#!" class="dashboard-card">
                        <div class="flex justify-between items-center">
                            <span class="dashboard-icon"><img src={{ asset('storage/images/dashboardicon1.png') }} alt=""
                                    class=""></span>
                            <span class="dashboard-link"><img src={{ asset('storage/images/dashboardarrow.png') }} alt=""
                                    class=""></span>
                        </div>
                        <p class="dashboard-title">My products</p>
                        <span class="dashboard-count">10</span>
                        <p class="dashboard-detail">+2.5% than last month</p>

                    </a>
                    <a href="#!" class="dashboard-card bg-white">
                        <div class="flex justify-between items-center">
                            <span class="dashboard-icon"><img src={{ asset('storage/images/dashboardicon2.png') }} alt=""
                                    class=""></span>
                            <span class="dashboard-link"><img src={{ asset('storage/images/dashboardarrow.png') }} alt=""
                                    class=""></span>
                        </div>
                        <p class="dashboard-title">My orders</p>
                        <span class="dashboard-count">37</span>
                        <p class="dashboard-detail">+3.5% than last month</p>

                    </a>
                    <a href="#!" class="dashboard-card bg-[#ECFBF2]">
                        <div class="flex justify-between items-center">
                            <span class="dashboard-icon"><img src={{ asset('storage/images/dashboardicon3.png') }} alt=""
                                    class=""></span>
                            <span class="dashboard-link"><img src={{ asset('storage/images/dashboardarrow.png') }} alt=""
                                    class=""></span>
                        </div>
                        <p class="dashboard-title">My earnings</p>
                        <span class="dashboard-count">₹5045.78</span>
                        <p class="dashboard-detail">+3.5% than last month</p>

                    </a>
                </div>
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 px-6 md:pl-14 md:pr-9">
                    <div class="rounded-[10px] border border-black/20 bg-white">
                        <div class="flex-box p-5 justify-between border-b border-black/20">
                            <span class="dashboard-title">Recent Transactions</span>
                            <button type="button" class="cursor-pointer"><img
                                    src={{ asset('storage/images/dashboard-popup.png') }} alt="" class="max-h-9"></button>
                        </div>
                        <ul class="dashboard-list overflow-x-scroll sm:overflow-x-hidden px-5 pt-5 pb-9">
                            <li class="flex justify-between items-center gap-x-4 sm:gap-x-10 md:gap-x-0">
                                <span class="dashboard-listicon">1</span>
                                <div>
                                    <h6 class="dashboard-title m-0">Baby Blanket</h6>
                                    <span class="order-detail">Order #1453,</span>
                                </div>
                                <span class="payment-details">Payment Received</span>
                                <span
                                    class="font-sans font-medium text-sm leading-tight tracking-1 text-black">+₹1,200</span>
                            </li>
                            <li class="flex justify-between items-center  gap-x-4 sm:gap-x-10 md:gap-x-0">
                                <span class="dashboard-listicon">2</span>
                                <div>
                                    <h6 class="dashboard-title m-0">Baby Blanket</h6>
                                    <span class="order-detail">Order #1453,</span>
                                </div>
                                <span class="payment-details">Payment Received</span>
                                <span
                                    class="font-sans font-medium text-sm leading-tight tracking-1 text-black">+₹1,200</span>
                            </li>
                            <li class="flex justify-between items-center  gap-x-4 sm:gap-x-10 md:gap-x-0">
                                <span class="dashboard-listicon">3</span>
                                <div>
                                    <h6 class="dashboard-title m-0">Baby Blanket</h6>
                                    <span class="order-detail">Order #1453,</span>
                                </div>
                                <span class="payment-details">Payment Received</span>
                                <span
                                    class="font-sans font-medium text-sm leading-tight tracking-1 text-black">+₹999</span>
                            </li>
                            <li class="flex justify-between items-center  gap-x-4 sm:gap-x-10 md:gap-x-0">
                                <span class="dashboard-listicon">4</span>
                                <div>
                                    <h6 class="dashboard-title m-0">Baby Blanket</h6>
                                    <span class="order-detail">Order #1453,</span>
                                </div>
                                <span class="payment-details">Payment Received</span>
                                <span
                                    class="font-sans font-medium text-sm leading-tight tracking-1 text-black">-</span>
                            </li>
                        </ul>
                    </div>
                    <div class="rounded-[10px] border border-black/20 bg-white">
                        <div class="flex-box p-5 justify-between border-b border-black/20">
                            <span class="dashboard-title">Revenue Summary</span>
                            <button type="button"
                                class="flex justify-center items-center gap-4 border border-black/20 rounded-[5px] px-2.5 py-2 cursor-pointer font-sans font-medium text-sm leading-tight tracking-1 text-silver"><img
                                    src={{ asset('storage/images/dashboard-filter.png') }} alt=""
                                    class="max-w-3"><span>Filter</span></button>
                        </div>
                        <div class="flex justify-start items-center px-5 pt-5 pb-9 gap-4">
                            <!-- Tab Buttons -->
                            <button class="tab-btn bg-white border-[1.18px] border-black/20 p-2 md:p-4 rounded-[5px]"
                                data-tab="tab1">Gross Revenue</button>
                            <button class="tab-btn bg-white border-[1.18px] border-black/20 p-2 md:p-4 rounded-[5px]"
                                data-tab="tab2">Gross Units Sold</button>
                            <button class="tab-btn bg-white border-[1.18px] border-black/20 p-2 md:p-4 rounded-[5px]"
                                data-tab="tab3">Return Units</button>
                        </div>

                        <!-- Content Div -->
                        <div class="tab-content px-5 pb-2.5">
                            <div id="tab1" class="tab-item">
                                <canvas id="wavyChart"></canvas>

                            </div>
                            <div id="tab2" class="tab-item hidden">
                                <canvas id="myChart"></canvas>

                            </div>
                            <div id="tab3" class="tab-item hidden">Lorem ipsum dolor sit amet, consectetur
                                adipisicing
                                elit. Qui reiciendis, alias veritatis magnam sunt rerum doloribus molestias sequi illo
                                quibusdam a minus quos recusandae modi eligendi, aut id saepe nisi?</div>
                        </div>

                    </div>
                </div>
                <div class="w-full mt-4 px-6 md:pl-14 md:pr-9">
                    <div class="container w-full max-w-full">
                        <div class="dashboard-card w-full bg-white p-0">
                            <div class="flex-box p-5 justify-between border-b border-black/20">
                                <h6 class="dashboard-title m-0">Recent Orders
                                </h6>
                                <button type="button"
                                    class="flex justify-center items-center gap-4 border border-black/20 rounded-[5px] px-2.5 py-2 cursor-pointer font-sans font-medium text-sm leading-tight tracking-1 text-silver"><img
                                        src={{ asset('storage/images/dashboard-filter.png') }} alt=""
                                        class="max-w-3"><span>Filter</span></button>
                            </div>
                            <div class="overflow-x-auto w-full p-0">
                                <table class="table-auto w-full sm:w-full seller-table">
                                    <thead>
                                        <tr class="border-b border-black/20">
                                            <th class="pl-5">Order ID</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#12337</td>
                                            <td>Baby Blanket</td>
                                            <td>29 Apr 2025</td>
                                            <td><span class="deliver-btn">Delivered</span></td>
                                            <td><span class="popup"><img src= {{ asset('storage/images/table-popup.png') }}
                                                        alt=""></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#12387</td>
                                            <td>Bottle Set</td>
                                            <td>12 Mar 2025</td>
                                            <td><span class="cancelled">Cancelled</span></td>
                                            <td><span class="popup"><img src= {{ asset('storage/images/table-popup.png') }}
                                                        alt=""></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#12387</td>
                                            <td>Bottle Set</td>
                                            <td>12 Mar 2025</td>
                                            <td><span class="processing">Processing</span></td>
                                            <td><span class="popup"><img src= {{ asset('storage/images/table-popup.png') }}
                                                        alt=""></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#12387</td>
                                            <td>Bottle Set</td>
                                            <td>12 Mar 2025</td>
                                            <td><span class="refund">Delivered</span></td>
                                            <td><span class="popup"><img src= {{ asset('storage/images/table-popup.png') }}
                                                        alt=""></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#12387</td>
                                            <td>Bottle Set</td>
                                            <td>12 Mar 2025</td>
                                            <td><span class="refund">Refund</span></td>
                                            <td><span class="popup"><img src= {{ asset('storage/images/table-popup.png') }}
                                                        alt=""></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#12387</td>
                                            <td>Bottle Set</td>
                                            <td>12 Mar 2025</td>
                                            <td><span class="deliver-btn">Delivered</span></td>
                                            <td><span class="popup"><img src= {{ asset('storage/images/table-popup.png') }}
                                                        alt=""></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#12387</td>
                                            <td>Bottle Set</td>
                                            <td>12 May 2025</td>
                                            <td><span class="processing">processing</span></td>
                                            <td><span class="popup"><img src= {{ asset('storage/images/table-popup.png') }}
                                                        alt=""></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#12387</td>
                                            <td>Bottle Set</td>
                                            <td>12 Mar 2025</td>
                                            <td><span class="refund">refund</span></td>
                                            <td><span class="popup"><img src= {{ asset('storage/images/table-popup.png') }}
                                                        alt=""></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#12387</td>
                                            <td>Bottle Set</td>
                                            <td>12 Mar 2025</td>
                                            <td><span class="cancelled">cancelled</span></td>
                                            <td><span class="popup"><img src= {{ asset('storage/images/table-popup.png') }}
                                                        alt=""></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>


</body>

</html>
