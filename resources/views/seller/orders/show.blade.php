@extends('seller.layouts.seller')

@section('title', 'Order Details')

@section('content')
    <div class="flex-[unset] sm:flex-1 w-full">
        @include('seller.layouts.header')
        <div class="flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-[45px]">
            <div class="w-full">
                <div class="flex items-center gap-4 mb-6">
                    <button type="button" onclick="window.history.back()"
                        class="flex-none w-9 h-9 rounded-full bg-black text-white flex items-center justify-center cursor-pointer">
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1182_398)">
                                <path d="M11.4647 21.4961L7.16551 17.1969L11.4647 12.8977" stroke="white"
                                    stroke-width="2.02667" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.16523 17.1969L27.2282 17.1969" stroke="white" stroke-width="2.02667"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_1182_398">
                                    <rect width="24.32" height="24.32" fill="white"
                                        transform="translate(17.1968 34.3937) rotate(-135)"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <div>
                        <h3
                            class="font-sans font-normal text-lg md:text-xl lg:text-2xl xl:text-3xl leading-tight tracking-1 text-black">
                            Order Details
                        </h3>
                        <p class="font-sans font-normal text-base leading-tight tracking-1 text-black">
                            Order ID: <span>{{ $order->order_number ?? $order->id }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 md:gap-5">
                    <!-- Order Summary -->
                    <div class="order-card">
                        <div>
                            <h2 class="order-card__title">Order Summary</h2>

                            <div class="order-table__head">
                                <span class="order-table__head-cell">Serial No.</span>
                                <span class="order-table__head-cell">Date</span>
                                <span class="order-table__head-cell">Price</span>
                            </div>

                            {{-- <div class="order-table__body">
                                <div class="order-table__row">
                                    <span class="order-table__cell-id">#12337</span>
                                    <span class="order-table__cell-date">23 Feb 2026</span>
                                    <span class="order-table__cell-price">₹500</span>
                                </div>
                                <div class="order-table__row">
                                    <span class="order-table__cell-id">#12387</span>
                                    <span class="order-table__cell-date">23 Feb 2026</span>
                                    <span class="order-table__cell-price">₹400</span>
                                </div>
                                <div class="order-table__row">
                                    <span class="order-table__cell-id">#16397</span>
                                    <span class="order-table__cell-date">23 Feb 2026</span>
                                    <span class="order-table__cell-price">₹760</span>
                                </div>
                            </div> --}}
                            <div class="order-table__body">
                                @foreach ($sellerItems as $item)
                                    <div class="order-table__row">
                                        <span class="order-table__cell-id">#{{ $item->id }}</span>
                                        <span class="order-table__cell-date">
                                            {{ $item->created_at->format('d M Y') }}
                                        </span>
                                        <span class="order-table__cell-price">
                                            ₹{{ $item->price }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="order-card__footer">
                            <button class="btn-order-track">Ready To Ship</button>
                        </div>
                    </div>

                    <!-- Shipping Progress -->
                    <div class="md:col-span-2 order-card">
                        <h2 class="order-card__title">Shipping Progress</h2>

                        <div class="stepper">

                            <!-- Step 1: Pending (done) -->
                            <div class="stepper__step">
                                <div class="stepper__circle stepper__circle--done">
                                    <svg class="stepper__check-icon" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <rect width="19.17" height="19.17" fill="url(#pattern0_2151_55)" />
                                        <defs>
                                            <pattern id="pattern0_2151_55" patternContentUnits="objectBoundingBox"
                                                width="1" height="1">
                                                <use xlink:href="#image0_2151_55" transform="scale(0.0078125)" />
                                            </pattern>
                                            <image id="image0_2151_55" width="128" height="128"
                                                preserveAspectRatio="none"
                                                xlink:href="data:image/png;base64,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" />
                                        </defs>
                                    </svg>
                                </div>
                                <span class="stepper__label">Pending</span>
                            </div>

                            <!-- Step 2: AWB Assigned (done) -->
                            <div class="stepper__step">
                                <div class="stepper__circle stepper__circle--done">
                                    <svg class="stepper__check-icon" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <rect width="19.17" height="19.17" fill="url(#pattern0_2151_55)" />
                                        <defs>
                                            <pattern id="pattern0_2151_55" patternContentUnits="objectBoundingBox"
                                                width="1" height="1">
                                                <use xlink:href="#image0_2151_55" transform="scale(0.0078125)" />
                                            </pattern>
                                            <image id="image0_2151_55" width="128" height="128"
                                                preserveAspectRatio="none"
                                                xlink:href="data:image/png;base64,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" />
                                        </defs>
                                    </svg>
                                </div>
                                <span class="stepper__label">AWB Assigned</span>
                            </div>

                            <!-- Step 3: Pickup (done) -->
                            <div class="stepper__step">
                                <div class="stepper__circle stepper__circle--done">
                                    <svg class="stepper__check-icon" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <rect width="19.17" height="19.17" fill="url(#pattern0_2151_55)" />
                                        <defs>
                                            <pattern id="pattern0_2151_55" patternContentUnits="objectBoundingBox"
                                                width="1" height="1">
                                                <use xlink:href="#image0_2151_55" transform="scale(0.0078125)" />
                                            </pattern>
                                            <image id="image0_2151_55" width="128" height="128"
                                                preserveAspectRatio="none"
                                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAHlklEQVR4Aeycy6odRRiFzzEQjYLoQMWJDr3gzImXgRkkoIJJvPsUCiIEVBC8QIb6ADrQRzgJqIkJCiL4BjrQgRp9AEHN5LjWoTucXdndXdV1r1qh/lN796Xqr7W+Xd3s3pWbdvSvawUEQNf27+wIAAHQuQKdD18zgADoXIHOh68ZQAB0rkCnwx+HrRlgVKLTWgB0avw4bAEwKtFpLQA6NX4ctgAYlei0FgCdGj8OWwCMSnRaC4DOjDeHKwBMRTp7LwA6M9wcrgAwFensvQDozHBzuALAVKSz9wKgM8PN4QoAU5EC3u/v7x9DPIt4G3EOcRZxAnE0dHoCILSiHu3B4JsR76KJq4gLiI8QZxHnEBcRv2H/64gjeO1Upg4WAFPKJN4OU+9Gl5cRHyDuQGwrPOYT7NjD8bej9i4CwFtC/wZgJo39Bi09gbApz+CgyzjvTtReRQB4yed/MkwczX/EsbVHcfxFnO8FgQCAirkKzFtr/piyNwQCYJQycQ3z70GXVxCun3ycslEIwQW0d+vGVss3AsBSqJCHwSyazxu+hwO1+zja+RThXASAs2R+J8B8TvuX0Eoo89HUQXkNbZ88eOXwRwA4iOV7KAziJz/EtD+VylvmjqX3AmBJoUD7B/NDTvvbMjuOfpzuBQTANhkDb4MpsaZ9M1N+VXyfuXHuvQCYUyfAPpgfe9o3szxmbph7LwDm1PHcN5gfe9o3s/zT3DD3XgDMqeOxD+anmvYPZ/nT7u7uX4c3LL0WAEsKrdgP81NP+2OWX4wvbGsBYKuU5XGD+amnfWb3O/7wSSEq+yIA7LVaPDKj+f8guRcx/f+N+qDY/hEAtkotHAfzc1zzmdV/+PMKzP8RtXMRAM6S3XjCYD6f5/s+2Lmx8fktNP8lmH9+/rDpvQJgWhurPTWbzwEKAKqwMmo3n8MWAFRhRbRgPoctAKiCY7RiPoctAKiCQ7RkPoctAKiCZdRgvuVQrh8mAK5LMf+iRfM5YgFAFRaiVfM5bAFAFWaiZfM5bAFAFSaidfM5bAFAFbZED+Zz2AKAKhjRi/kcdnAAIN5RxEkE17RzbTvXuHOtu9Nv1ZhcjkDeuX7M8S/Ge9rnwQ7Ody7BAIBwRxBvIAP+MOFr1FzTzrXtXOPOte5Xsf8dBH+5it3lFeRG83P8mIPmn4H5X61VZe15QQCAcFyrvockPkbchdhWuOb9Q+zgsmY+O8fLcgrG0J35VN8bAAhH80ku16yzzaV4Egd8h/PuRV1EQS4EMsZyraXx8Xn+yzk++WNiXgBAuNH8x8YGLesHcNwVnJ8dAuRA86v8MQc09C6rAYBwa80fk84OAcbQtfk0YhUAEI7rz75EA66ffJyyUQjBJbTH6+/Gjthvhj5jLtScGgJv+JLf7U8lswoANPYZgmvSUXkXLpPmjWEyCAbzu7rbn3LJGQCI9zQaexURshCCb9F29HsC9MFpv8sbvm2GOQOARt5ExCjRLwcwn7NMU9O+rxFOAEDA29DhU4hYhTNBlMsBcqf5mvYN55wAwLn3I2J/k0cIgl4OYL6mfRi3rbgCcMu2RiJsC3Y5gPn85GvanzDJFQCntecTfdpu5kzgdTkYzNe0P6O4EwD4ypIA/DzTXuhdhGDV5QDma9q3cMMJgKG9z4c6VeV8OYD5mvYt3VkDANeg/2HZfqjDOBNYXQ4G8zXtWyrvDAAuA1yD/gLa55p0VMnKIgQ9mR9KdWcA2DEg4Fr0M3idA4Kt9wQwP9c1/xp0yPpIF/2vLqsAYG+AgL/6yQEB7wk2HiUP5ud4pEvz+T9zrF6fTy1zxmoAmHQJEMh8OrE+vABgtwMEz+M1H3OiSlY4E/ChTq4veU5h7NV+8keXvAFgQxCCPwk7jdc57gl4c4iukxVO+9Ve802VggDARgFBrnsCdp8qaH7V13xTqGAAsOHGIWjOfHoWFAA22CgExZhPjUNGcACYXGMQNGs+vYoCABtuBIKmzadP0QBg45VD0Lz59CgqAOygUgi6MJ/+RAeAnVQGQTfm05skALCjSiDoynz6kgwAdnYIgtRfG7P7pejOfAqSFAB2OEDAr41LgqB486ldjEgOAAdRGATdmk8vsgDAjguBoGvz6UM2ANh5Zgi6N58eZAWACWSCQOZTfER2AJDDTmIIZD5FH6IIAJhLIghkPsU+FMUAwJwiQyDzKbIRRQHA3CJBUK351CRmFAcABxsYAplPUSeiSACYayAIZD7FnIliAWDOnhDIfIq4EEUDwNxXQiDzKZ5FFA8Ax+AIgcynaJZRBQAciyUEMp9iOUQ1AHBMAwQn8PpXhFl+wYbjOKb65VoYR7JSFQBUBQZ/j/pBxCnEe0M8h/oh7PsBdRMl1SCqA4DCwOhriD3E+0OcR83pn7sVDgpUCYDD+HToggICYEGg1ncLgNYdXhifAFgQqPXdAqB1hxfGJwAWBGp9twAozOHU6QiA1IoX1p8AKMyQ1OkIgNSKF9afACjMkNTpCIDUihfWnwAozJDU6QiA1IoX1p8AKMSQXGkIgFzKF9KvACjEiFxpCIBcyhfSrwAoxIhcaQiAXMoX0q8AKMSIXGkIgFzKF9KvAMhsRO7u/wcAAP//HImHxAAAAAZJREFUAwCfmXkf0nbWqQAAAABJRU5ErkJggg==" />
                                        </defs>
                                    </svg>
                                </div>
                                <span class="stepper__label">Pickup</span>
                            </div>

                            <!-- Step 4: Transit (pending) -->
                            <div class="stepper__step">
                                <div class="stepper__circle stepper__circle--pending">
                                    <span class="stepper__step-number">4</span>
                                </div>
                                <span class="stepper__label">Transit</span>
                            </div>

                            <!-- Step 5: OFD (pending) -->
                            <div class="stepper__step">
                                <div class="stepper__circle stepper__circle--pending">
                                    <span class="stepper__step-number">5</span>
                                </div>
                                <span class="stepper__label">OFD</span>
                            </div>

                        </div>

                        <div class="shipping-card__divider"></div>

                        <div class="shipping-card__bottom">
                            <div class="shipping-info">

                                <div class="shipping-info__row">
                                    <span class="shipping-info__label">Shipping Provider</span>
                                    <span class="shipping-info__label">{{ $order->shipping_provider ?? 'N/A' }}</span>
                                </div>

                                <div class="shipping-info__row">
                                    <span class="shipping-info__label--bold">AWB Number</span>
                                    <div class="shipping-info__value-group">
                                        <span class="shipping-info__label--bold">AWB123456789</span>
                                        <button class="shipping-info__copy-btn" title="Copy AWB">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="15"
                                                viewBox="0 0 15 15" fill="none">
                                                <rect width="15" height="15" fill="url(#pattern0_2156_264)" />
                                                <defs>
                                                    <pattern id="pattern0_2156_264"
                                                        patternContentUnits="objectBoundingBox" width="1"
                                                        height="1">
                                                        <use xlink:href="#image0_2156_264" transform="scale(0.0078125)" />
                                                    </pattern>
                                                    <image id="image0_2156_264" width="128" height="128"
                                                        preserveAspectRatio="none"
                                                        xlink:href="data:image/png;base64,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" />
                                                </defs>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="shipping-info__row">
                                    <span class="shipping-info__label--bold">Shipment ID</span>
                                    <span class="shipping-info__label--bold">SHIP2026022300123</span>
                                </div>

                            </div>

                            <div class="text-center">
                                <button class="btn-order-track">Tracking</button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Row 2: Timeline -->
                <div class="order-card">
                    <h2 class="order-card__title">Timeline</h2>

                    <div class="timeline">
                        <div class="timeline__connector"></div>

                        <div class="timeline__events">

                            <!-- Event 1: AWB Created -->
                            <div class="timeline__event-block timeline__event--start">
                                <div class="timeline__dot"></div>
                                <div class="timeline__event-body--start">
                                    <p class="timeline__event-title">AWB Created</p>
                                    <p class="timeline__event-sub">23 Feb 2026, 09:15 AM</p>
                                    <p class="timeline__event-sub">AWB number assigned by Shiprocket</p>
                                </div>
                            </div>

                            <!-- Event 2: Pickup Scheduled -->
                            <div class="timeline__event-block timeline__event--center">
                                <div class="timeline__dot"></div>
                                <div class="timeline__event-body--center">
                                    <p class="timeline__event-title">Pickup Scheduled</p>
                                    <p class="timeline__event-sub">pickup on 23 Feb 2026</p>
                                </div>
                            </div>

                            <!-- Event 3: Order Packed -->
                            <div class="timeline__event-block timeline__event--center">
                                <div class="timeline__dot"></div>
                                <div class="timeline__event-body--center">
                                    <p class="timeline__event-title">Order Packed</p>
                                    <p class="timeline__event-sub">Order packed and ready</p>
                                </div>
                            </div>

                            <!-- Event 4: Payment Confirmed -->
                            <div class="timeline__event-block timeline__event--center">
                                <div class="timeline__dot timeline__dot-pending"></div>
                                <div class="timeline__event-body--center">
                                    <p class="timeline__event-title">Payment Confirmed</p>
                                    <p class="timeline__event-sub">Payment received via UPI</p>
                                </div>
                            </div>

                            <!-- Event 5: Order Placed -->
                            <div class="timeline__event-block timeline__event--end">
                                <div class="timeline__dot timeline__dot-pending"></div>
                                <div class="timeline__event-body--end">
                                    <p class="timeline__event-title">Order Placed</p>
                                    <p class="timeline__event-sub">Order placed by customer</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ── Print Button ── -->
                <div class="print-row">
                    <button class="print-btn" title="Print Order">
                        <svg class="print-btn__icon" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="39" height="39" viewBox="0 0 39 39"
                            fill="none">
                            <rect width="39" height="39" fill="url(#pattern0_2157_386)" />
                            <defs>
                                <pattern id="pattern0_2157_386" patternContentUnits="objectBoundingBox" width="1"
                                    height="1">
                                    <use xlink:href="#image0_2157_386" transform="scale(0.0078125)" />
                                </pattern>
                                <image id="image0_2157_386" width="128" height="128" preserveAspectRatio="none"
                                    xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAADsQAAA7EB9YPtSQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAc4SURBVHic7Z1LjBRFGMd/O7sHYZEgLI8dQFHDwyBojC+UcEH0oCAHUYJPBERjNPHswQNHYwTxBT4uSjQrBxAMITxiIopGBRPFIBgeYV0EBFRWISCsh1p02a1aZqanHj3f90vqMt3T/a+q/3R93VP1dR1pMR6YCUwFisAIoDGqouz8BbQCvwCbgFXAj1EVJcgUYCvQIaR8AUyuSsvlnEbgA+J3SKyygvxf4SrmcmA78TshdtkGjMzYlrmjP7CD+I2fStkJDMjUohVSF+Gc9cA6YJpj+zlMPLAB2I8JovJMIzAKuAOYBBQc+60H7gbOhpEVjwW4fwkbgQnxpHlnIrAZd/0fjyctDH0xt0O2yi/GXB1qnXpgCfY2aMW0Uc0yH3vFPyTOcBSLOqAFe1vMi6jLO5/Qs8LHgUExRUWiCfidnu2xJqYon/QBTtGzwi/GFBWZl+jZHieBS2KK8sVY7Jc8yU/EpmBvk9GhBLhuSXxQdHy+M6CG1HDV3dVWVSekAQY6Pj8aUENqHHF83hRKQEgDuM7VEVBDarjqHqxfQhpASRA1gHDUAMJRAwhHDSAcNYBw1ADCUQMIRw0gHDWAcNQAwlEDCEcNIBw1gHDUAMJRAwhHDSCcUubiNwH3YJYtjQWGAkN8ilIq5jBwCPgJMwV/DRmm3BWB5cAZ4i+e1FJZOQMsA5opkycxizJjV0BLdUo78AQl0AC8moBgLX7K0s4+dvJaAiK1+C2v0IWuQeBTwOu42Qt8DOzGBBuV0owJIn8m/2v/q0U/4GpMux7McJwhwBhgOnBlL/stxMR3/1HEPea3ArORtXo379QBc4A27H3aTrfAcLljx23dd1RyRRF3HqZl53dqwn6r14p2fi1QxH4lOEPnsvy5lo0dwAMRxCp+eBB7Hz8KsNKyYQ865tcSBWAfPfu5pYB9Lfqazh2U2uAc9swjowvY16JLXrNfq9j6tFjAnp9H8pr9WsWWi2BwAftYr5f/2sPWp3U6H0A4agDhqAGEowYQjhpAOGoA4agBhKMGEI4aQDhqAOGoAYSjBhCOGkA4agDhqAGEowYQjhpAOGoA4agBhKMGEI4aQDhqAOH0mi3CA5cCzwLXIuNN4eVwFvgek8XjRKiThjRAA7AZuDHgOfPGbOBe4HbgnxAnDDkE3Ip2finc3FmCENIAmmugdIaHOpEGgcIJHQTa+Ci2gMjMinnyFAxwf2wBkYm6EFeHAOGoAYSjBhCOGkA4agDhqAGEU8CROya0EMU71lxQBeA3y4Ymz2KU8Nhe83O4gD09+VjPYpTw2Pr0YAMm///EbhumA89hMkymRCXzCQ4CbwE/+BKVAwqYPu3OboDHsCcSnlNlEbMc5ymVBuBrxzEuVk5iTJMiNr3V/n/gEcd5HgaTKdSWLr4NexrZSslqgMmO75daFlejEh7wbYDhmKtg93OcBgYVMGlh37V8sRnz7rlqmiALWf80kZj9dDimD4dZtr1Dl5TAzZjXiNjc2IbJN5/1mUE1hoCvHMe4WPkbGJ9Rvy98XAEKwEPYf/kdmDmHw+DCe8OFwJu9HHQfJuX4LszbKctlEiaw7E45zxz6Ac9ggtZSg8A2TBC4o4zzhMT2I3gZ2FrBsYZiXho1A7iil/0WAG/bNiwl2zhbSZFO6Pa+4LVx3WkgvAmkE7rzS5oEtAAzTqgB/BOijU8A88sVNgwTE5z2LE46Ptv2NPAG9rsAoLQAbCD/vz5+HCbQGFpWFXtH+h9P1fwRHAJ+xbw+fi3mFvBYFY+fiay3gQBTgO8wq2ZCjZu20o6ZzVyNP81sxw82UziFWcGlMhBYDQyILQRoBO7DdFauZzXnaULITaTR+V25M7aArOTJAHtJL2jcE1tAVvJkgF3AItIxwTHMU8lck6cYAOAF4H1gAnHzC7QDXwLHI2qoCnkzAJhJDLtji6gV8jQEKB5QAwhHDSCcPMYAY4ifZKodMzklmceslZI3AywCnieN/w+OYyZebIktJAt5GgLGkE7nA1zGRSZX5IE8GWAU6XT+ea6KLSAreTLAN6T34GV9bAFZyZMBjmGSKG7HZNWMSTvQAjwdWUdm8hYEfgbcEFtELZGnK4DigZAGcC00TS2wC4mr7sEW5YY0wFHH55JzEdjW7AMcCSUgpAHaHJ+PC6ghNVx1t+Vs8EJIAxwATlk+nxFQQ2rY6n4K01Y1yVp6zoD9E/elsJYZDPxBz/ZYHVOUb+ZjnwbdgqxgsA5Yib0t5kXU5Z2+QCv2ii9Bxmtk6nGvvzwA9IknLQzzcC+42AxcF0+ad64HPsVd/7mhBcW47NZjlizd5dh+DjPhcgOwH/PYNc/0w/yRNQ24BXfgvQ6zBC+1xFxe6I9J2BBzeVdKZSfpLXrxzkhgG/EbP3b5trMtRNIIrCB+J8Qq72ECY/FMBj4nfoeEKluA26rSchlJ7d77GmAmMBWT4mwEJojKM+2YW99WYBOwCjPmJ8G/pImcQEB1zJ0AAAAASUVORK5CYII=" />
                            </defs>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
