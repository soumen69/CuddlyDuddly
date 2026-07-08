 <div id="panel-legal" style="display:none;">

     <div class="settings-card">
         <div class="settings-title">Legal &amp; Platform Policies</div>

         <div class="policy-grid" style="margin-bottom:18px;">
             <div class="policy-card">
                 <p class="policy-card-title">Return Policy</p>
                 <div class="policy-card-text">Customers can return/exchange an item within 30 days of
                     purchase. Original packaging must be intact for hygiene products.</div>
             </div>
             <div class="policy-card">
                 <p class="policy-card-title">Shipping Policy</p>
                 <div class="policy-card-text">Customers can return/exchange an item within 30 days of
                     purchase. Original packaging must be intact for hygiene products.</div>
             </div>
         </div>

         <form id="documentForm" action="{{ route('seller.setting.documents.save', $seller->slug) }}" method="POST"
             enctype="multipart/form-data">
             @csrf
             <!-- Document uploads -->
             <div class="doc-grid">
                 <!-- GST Certificate -->
                 <div class="doc-card" id="doc-gst" onclick="triggerUpload('input-gst', 'doc-gst')">
                     <input type="file" id="input-gst" name="gst" accept=".pdf,.jpg,.jpeg,.png"
                         style="display:none" onchange="handleUpload(this, 'doc-gst')">
                     <div class="doc-card-icon" id="icon-gst">
                         <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16"
                             fill="none">
                             <path
                                 d="M5.5 16C3.98333 16 2.6875 15.475 1.6125 14.425C0.5375 13.375 0 12.0917 0 10.575C0 9.275 0.391667 8.11667 1.175 7.1C1.95833 6.08333 2.98333 5.43333 4.25 5.15C4.66667 3.61667 5.5 2.375 6.75 1.425C8 0.475 9.41667 0 11 0C12.95 0 14.6042 0.679167 15.9625 2.0375C17.3208 3.39583 18 5.05 18 7C19.15 7.13333 20.1042 7.62917 20.8625 8.4875C21.6208 9.34583 22 10.35 22 11.5C22 12.75 21.5625 13.8125 20.6875 14.6875C19.8125 15.5625 18.75 16 17.5 16H12C11.45 16 10.9792 15.8042 10.5875 15.4125C10.1958 15.0208 10 14.55 10 14V8.85L8.4 10.4L7 9L11 5L15 9L13.6 10.4L12 8.85V14H17.5C18.2 14 18.7917 13.7583 19.275 13.275C19.7583 12.7917 20 12.2 20 11.5C20 10.8 19.7583 10.2083 19.275 9.725C18.7917 9.24167 18.2 9 17.5 9H16V7C16 5.61667 15.5125 4.4375 14.5375 3.4625C13.5625 2.4875 12.3833 2 11 2C9.61667 2 8.4375 2.4875 7.4625 3.4625C6.4875 4.4375 6 5.61667 6 7H5.5C4.53333 7 3.70833 7.34167 3.025 8.025C2.34167 8.70833 2 9.53333 2 10.5C2 11.4667 2.34167 12.2917 3.025 12.975C3.70833 13.6583 4.53333 14 5.5 14H8V16H5.5Z"
                                 fill="#BA0034" />
                         </svg>
                     </div>
                     <p class="doc-card-name">GST Certificate</p>
                     <p class="doc-card-size" id="size-gst">PDF, JPG · 50 - 200KB</p>
                     <div class="doc-card-filename" id="fname-gst"
                         style="{{ $seller->businessDetail?->gst ? 'display:flex' : 'display:none' }}">

                         @if ($seller->businessDetail?->gst)
                             <a href="{{ asset('storage/' . $seller->businessDetail->gst) }}" target="_blank"
                                 onclick="event.stopPropagation();"
                                 style=" margin-left:10px;color:#BA0034; text-decoration:none; font-weight:600;">👁
                                 View
                             </a>
                         @endif

                     </div>
                     <button class="doc-card-remove" id="remove-gst" onclick="deleteDocument('gst')"
                         style="{{ $seller->businessDetail?->gst ? 'display:block' : 'display:none' }}"
                         onclick="removeUpload(event,'input-gst','doc-gst','icon-gst','size-gst','fname-gst','remove-gst')">✕
                         Remove
                     </button>
                 </div>

                 <!-- PAN Card -->
                 <div class="doc-card" id="doc-pan" onclick="triggerUpload('input-pan', 'doc-pan')">
                     <input type="file" id="input-pan" name="pan" accept=".pdf,.jpg,.jpeg,.png"
                         style="display:none" onchange="handleUpload(this, 'doc-pan')">
                     <div class="doc-card-icon" id="icon-pan">
                         <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16"
                             fill="none">
                             <path
                                 d="M5.5 16C3.98333 16 2.6875 15.475 1.6125 14.425C0.5375 13.375 0 12.0917 0 10.575C0 9.275 0.391667 8.11667 1.175 7.1C1.95833 6.08333 2.98333 5.43333 4.25 5.15C4.66667 3.61667 5.5 2.375 6.75 1.425C8 0.475 9.41667 0 11 0C12.95 0 14.6042 0.679167 15.9625 2.0375C17.3208 3.39583 18 5.05 18 7C19.15 7.13333 20.1042 7.62917 20.8625 8.4875C21.6208 9.34583 22 10.35 22 11.5C22 12.75 21.5625 13.8125 20.6875 14.6875C19.8125 15.5625 18.75 16 17.5 16H12C11.45 16 10.9792 15.8042 10.5875 15.4125C10.1958 15.0208 10 14.55 10 14V8.85L8.4 10.4L7 9L11 5L15 9L13.6 10.4L12 8.85V14H17.5C18.2 14 18.7917 13.7583 19.275 13.275C19.7583 12.7917 20 12.2 20 11.5C20 10.8 19.7583 10.2083 19.275 9.725C18.7917 9.24167 18.2 9 17.5 9H16V7C16 5.61667 15.5125 4.4375 14.5375 3.4625C13.5625 2.4875 12.3833 2 11 2C9.61667 2 8.4375 2.4875 7.4625 3.4625C6.4875 4.4375 6 5.61667 6 7H5.5C4.53333 7 3.70833 7.34167 3.025 8.025C2.34167 8.70833 2 9.53333 2 10.5C2 11.4667 2.34167 12.2917 3.025 12.975C3.70833 13.6583 4.53333 14 5.5 14H8V16H5.5Z"
                                 fill="#BA0034" />
                         </svg>
                     </div>
                     <p class="doc-card-name">PAN Card</p>
                     <p class="doc-card-size" id="size-pan">PDF, JPG · 50 - 200KB</p>
                     <div class="doc-card-filename" id="fname-pan"
                         style="{{ $seller->businessDetail?->pan ? 'display:block' : 'display:none' }}">

                         @if ($seller->businessDetail?->pan)
                             <a href="{{ asset('storage/' . $seller->businessDetail->pan) }}" target="_blank"
                                 onclick="event.stopPropagation();"
                                 style=" margin-left:10px;color:#BA0034; text-decoration:none; font-weight:600;">👁
                                 View
                             </a>
                         @endif
                     </div>
                     <button class="doc-card-remove" id="remove-pan" onclick="deleteDocument('pan')"
                         style="{{ $seller->businessDetail?->pan ? 'display:block' : 'display:none' }}"
                         onclick="removeUpload(event,'input-pan','doc-pan','icon-pan','size-pan','fname-pan','remove-pan')">✕
                         Remove</button>
                 </div>

                 <!-- Business License -->
                 <div class="doc-card" id="doc-biz" onclick="triggerUpload('input-biz', 'doc-biz')">
                     <input type="file" id="input-biz" name="business_license" accept=".pdf,.jpg,.jpeg,.png"
                         style="display:none" onchange="handleUpload(this, 'doc-biz')">
                     <div class="doc-card-icon" id="icon-biz">
                         <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16"
                             fill="none">
                             <path
                                 d="M5.5 16C3.98333 16 2.6875 15.475 1.6125 14.425C0.5375 13.375 0 12.0917 0 10.575C0 9.275 0.391667 8.11667 1.175 7.1C1.95833 6.08333 2.98333 5.43333 4.25 5.15C4.66667 3.61667 5.5 2.375 6.75 1.425C8 0.475 9.41667 0 11 0C12.95 0 14.6042 0.679167 15.9625 2.0375C17.3208 3.39583 18 5.05 18 7C19.15 7.13333 20.1042 7.62917 20.8625 8.4875C21.6208 9.34583 22 10.35 22 11.5C22 12.75 21.5625 13.8125 20.6875 14.6875C19.8125 15.5625 18.75 16 17.5 16H12C11.45 16 10.9792 15.8042 10.5875 15.4125C10.1958 15.0208 10 14.55 10 14V8.85L8.4 10.4L7 9L11 5L15 9L13.6 10.4L12 8.85V14H17.5C18.2 14 18.7917 13.7583 19.275 13.275C19.7583 12.7917 20 12.2 20 11.5C20 10.8 19.7583 10.2083 19.275 9.725C18.7917 9.24167 18.2 9 17.5 9H16V7C16 5.61667 15.5125 4.4375 14.5375 3.4625C13.5625 2.4875 12.3833 2 11 2C9.61667 2 8.4375 2.4875 7.4625 3.4625C6.4875 4.4375 6 5.61667 6 7H5.5C4.53333 7 3.70833 7.34167 3.025 8.025C2.34167 8.70833 2 9.53333 2 10.5C2 11.4667 2.34167 12.2917 3.025 12.975C3.70833 13.6583 4.53333 14 5.5 14H8V16H5.5Z"
                                 fill="#BA0034" />
                         </svg>
                     </div>
                     <p class="doc-card-name">Business License</p>
                     <p class="doc-card-size" id="size-biz">PDF, JPG · 50 - 200KB</p>
                     <div class="doc-card-filename" id="fname-biz"
                         style="{{ $seller->businessDetail?->business_license ? 'display:block' : 'display:none' }}">

                         @if ($seller->businessDetail?->business_license)
                             <a href="{{ asset('storage/' . $seller->businessDetail->business_license) }}"
                                 target="_blank" onclick="event.stopPropagation();"
                                 style=" margin-left:10px;color:#BA0034; text-decoration:none; font-weight:600;">👁
                                 View
                             </a>
                         @endif
                     </div>
                     <button class="doc-card-remove" id="remove-biz" onclick="deleteDocument('business_license')"
                         style="{{ $seller->businessDetail?->business_license ? 'display:block' : 'display:none' }}"
                         onclick="removeUpload(event,'input-biz','doc-biz','icon-biz','size-biz','fname-biz','remove-biz','business_license')">✕
                         Remove</button>
                 </div>

                 <!-- Address Proof -->
                 <div class="doc-card" id="doc-addr" onclick="triggerUpload('input-addr', 'doc-addr')">
                     <input type="file" id="input-addr" name="address_proof" accept=".pdf,.jpg,.jpeg,.png"
                         style="display:none" onchange="handleUpload(this, 'doc-addr')">
                     <div class="doc-card-icon" id="icon-addr">
                         <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16"
                             fill="none">
                             <path
                                 d="M5.5 16C3.98333 16 2.6875 15.475 1.6125 14.425C0.5375 13.375 0 12.0917 0 10.575C0 9.275 0.391667 8.11667 1.175 7.1C1.95833 6.08333 2.98333 5.43333 4.25 5.15C4.66667 3.61667 5.5 2.375 6.75 1.425C8 0.475 9.41667 0 11 0C12.95 0 14.6042 0.679167 15.9625 2.0375C17.3208 3.39583 18 5.05 18 7C19.15 7.13333 20.1042 7.62917 20.8625 8.4875C21.6208 9.34583 22 10.35 22 11.5C22 12.75 21.5625 13.8125 20.6875 14.6875C19.8125 15.5625 18.75 16 17.5 16H12C11.45 16 10.9792 15.8042 10.5875 15.4125C10.1958 15.0208 10 14.55 10 14V8.85L8.4 10.4L7 9L11 5L15 9L13.6 10.4L12 8.85V14H17.5C18.2 14 18.7917 13.7583 19.275 13.275C19.7583 12.7917 20 12.2 20 11.5C20 10.8 19.7583 10.2083 19.275 9.725C18.7917 9.24167 18.2 9 17.5 9H16V7C16 5.61667 15.5125 4.4375 14.5375 3.4625C13.5625 2.4875 12.3833 2 11 2C9.61667 2 8.4375 2.4875 7.4625 3.4625C6.4875 4.4375 6 5.61667 6 7H5.5C4.53333 7 3.70833 7.34167 3.025 8.025C2.34167 8.70833 2 9.53333 2 10.5C2 11.4667 2.34167 12.2917 3.025 12.975C3.70833 13.6583 4.53333 14 5.5 14H8V16H5.5Z"
                                 fill="#BA0034" />
                         </svg>
                     </div>
                     <p class="doc-card-name">Address Proof</p>
                     <p class="doc-card-size" id="size-addr">PDF, JPG · 50 - 200KB</p>
                     <div class="doc-card-filename" id="fname-addr"
                         style="{{ $seller->businessDetail?->address_proof ? 'display:block' : 'display:none' }}">
                         @if ($seller->businessDetail?->address_proof)
                             <a href="{{ asset('storage/' . $seller->businessDetail->address_proof) }}"
                                 target="_blank" onclick="event.stopPropagation();"
                                 style=" margin-left:10px;color:#BA0034; text-decoration:none; font-weight:600;">👁
                                 View
                             </a>
                         @endif
                     </div>
                     <button class="doc-card-remove" id="remove-addr" onclick="deleteDocument('address_proof')"
                         style="{{ $seller->businessDetail?->address_proof ? 'display:block' : 'display:none' }}"
                         onclick="removeUpload(event,'input-addr','doc-addr','icon-addr','size-addr','fname-addr','remove-addr','address_proof')">✕
                         Remove</button>
                 </div>
                 <input type="hidden" name="removed_documents" id="removed_documents">

                 <div class="legal-checkbox-row">
                     <input type="checkbox" id="legalCheck" name="legal_check" required>
                     <label for="legalCheck">
                         I hereby declare that the documents uploaded are authentic and the policies mentioned above
                         comply with Cuddly Duddly marketplace standards.
                     </label>
                 </div>

                 <div style="margin-top:16px;">
                     <button type="submit" class="btn-pink">Save</button>
                 </div>
         </form>
     </div>

 </div>

 </div>
