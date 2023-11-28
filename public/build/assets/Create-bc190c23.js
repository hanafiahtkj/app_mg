import{T as f,m as k,j as b,b as t,f as i,v as n,u as e,n as d,t as r,e as v,q as w,H as g,o as y}from"./app-ece2a1fe.js";/* empty css                      *//* empty css                */import{S as x}from"./sweetalert2.all-2d76b64b.js";/* empty css            */import"./app-82ed81c5.js";/* empty css                                                            */const C=["onSubmit"],B={class:"modal fade text-left",id:"inlineForm",tabindex:"-1","aria-labelledby":"myModalLabel33","aria-hidden":"true",style:{display:"none"}},S={class:"modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg",role:"document"},T={class:"modal-content"},P=w('<div class="modal-header"><h4 class="modal-title" id="myModalLabel33">Create</h4><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button></div>',1),M={class:"modal-body"},V=t("h6",null,"No PKWT",-1),F={class:"form-group"},L={class:"invalid-feedback"},E=t("h6",null,"Lama PKWT (Bulan)",-1),I={class:"form-group"},K={class:"invalid-feedback"},U={class:"row"},W={class:"col-md-6 col-12"},D=t("h6",null,"Mulai PKWT",-1),N={class:"form-group"},j={class:"invalid-feedback"},q={class:"col-md-6 col-12"},A=t("h6",null,"Akhir PKWT",-1),z={class:"form-group"},H={class:"invalid-feedback"},O={class:"row"},Y={class:"col-md-6 col-12"},G=t("h6",null,"Tanggal Pencataan PKWT",-1),J={class:"form-group"},Q={class:"invalid-feedback"},R={class:"modal-footer",style:{"background-color":"#f6f8fb"}},X=t("button",{type:"button",class:"btn bg-white btn-outline-default border me-auto","data-bs-dismiss":"modal","aria-label":"Close"},[t("i",{class:"bx bx-x d-block d-sm-none"}),t("span",{class:"d-none d-sm-block"},"Close")],-1),Z=["disabled"],$=t("i",{class:"bx bx-check d-block d-sm-none"},null,-1),tt=t("span",{class:"d-none d-sm-block"},"Simpan",-1),ot=[$,tt],pt={__name:"Create",props:{idPerusahaan:Number,perusahaan:{type:Object},redrawDataTable:{type:Function}},setup(_){const m=_,{show:et,close:st,redirect:u}=g();let c,p;const o=f({id_perusahaan:m.idPerusahaan??"",no_pkwt:"",lama_pkwt:"",mulai_pkwt:"",akhir_pkwt:"",tgl_pencatatan_pkwt:""}),h=async()=>{o.post(route("dashboard.pkwt.store"),{preserveScroll:!0,onFinish:()=>{},onSuccess:()=>{x.fire({title:"Berhasil disimpan!",icon:"success",showCloseButton:!0}),p.addEventListener("hidden.bs.modal",l=>{m.redrawDataTable()}),c.hide()}})};return k(()=>{flatpickr(".flatpickr-no-config",{dateFormat:"Y-m-d"}),c=new bootstrap.Modal(document.getElementById("inlineForm")),c.show(),p=document.getElementById("inlineForm"),p.addEventListener("hidden.bs.modal",u);let l=document.querySelectorAll(".choices2");for(let s=0;s<l.length;s++)l[s].classList.contains("multiple-remove")?new Choices(l[s],{delimiter:",",editItems:!0,maxItemCount:-1,removeItemButton:!0}):new Choices(l[s])}),(l,s)=>(y(),b("form",{onSubmit:v(h,["prevent"]),autocomplete:"off",novalidate:""},[t("div",B,[t("div",S,[t("div",T,[P,t("div",M,[V,t("div",F,[i(t("input",{type:"text",placeholder:"",class:d(["form-control",{"is-invalid":e(o).errors.no_pkwt}]),"onUpdate:modelValue":s[0]||(s[0]=a=>e(o).no_pkwt=a),autocomplete:"off"},null,2),[[n,e(o).no_pkwt]]),t("div",L,r(e(o).errors.no_pkwt),1)]),E,t("div",I,[i(t("input",{type:"text",placeholder:"",class:d(["form-control",{"is-invalid":e(o).errors.lama_pkwt}]),"onUpdate:modelValue":s[1]||(s[1]=a=>e(o).lama_pkwt=a),autocomplete:"off"},null,2),[[n,e(o).lama_pkwt]]),t("div",K,r(e(o).errors.lama_pkwt),1)]),t("div",U,[t("div",W,[D,t("div",N,[i(t("input",{type:"text",placeholder:"",class:d(["form-control flatpickr-no-config flatpickr-input",{"is-invalid":e(o).errors.mulai_pkwt}]),"onUpdate:modelValue":s[2]||(s[2]=a=>e(o).mulai_pkwt=a),autocomplete:"off"},null,2),[[n,e(o).mulai_pkwt]]),t("div",j,r(e(o).errors.mulai_pkwt),1)])]),t("div",q,[A,t("div",z,[i(t("input",{type:"text",placeholder:"",class:d(["form-control flatpickr-no-config flatpickr-input",{"is-invalid":e(o).errors.akhir_pkwt}]),"onUpdate:modelValue":s[3]||(s[3]=a=>e(o).akhir_pkwt=a),autocomplete:"off"},null,2),[[n,e(o).akhir_pkwt]]),t("div",H,r(e(o).errors.akhir_pkwt),1)])])]),t("div",O,[t("div",Y,[G,t("div",J,[i(t("input",{type:"text",placeholder:"",class:d(["form-control flatpickr-no-config flatpickr-input",{"is-invalid":e(o).errors.tgl_pencatatan_pkwt}]),"onUpdate:modelValue":s[4]||(s[4]=a=>e(o).tgl_pencatatan_pkwt=a),autocomplete:"off"},null,2),[[n,e(o).tgl_pencatatan_pkwt]]),t("div",Q,r(e(o).errors.tgl_pencatatan_pkwt),1)])])])]),t("div",R,[X,t("button",{type:"submit",class:"btn btn-primary ms-1",disabled:e(o).processing},ot,8,Z)])])])])],40,C))}};export{pt as default};
