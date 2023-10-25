import { defineStore } from "pinia";
import axios from "axios";
import NProgress from "nprogress";
import toastr from "toastr";
import "toastr/toastr.scss";
import _ from "lodash";

export const PropertyStore = defineStore({
    id: "PropertyStoreId",
    state: () => ({
        current_pagination_page: "",
        properties: {},
        pagination: {
            searchQuery: "",
            sortby: "",
            direction: "",
        },
        amenities: {},
        update_property_form_data: {
            name: "",
            details: "",
            type: [],
            size: [],
            address: "",
            brochure: "",
            amenity_id: [],
        },
        property_type: [
            {
                id: "residential",
                name: "Residential",
            },
            {
                id: "commercial",
                name: "Commercial",
            },
        ],
        pdf_file: "",
    }),
    getters: {
        getProperties: (state) => state.properties,
        getPdfFile: (state) => state.pdf_file,
    },
    actions: {
        async getPropertyList(pagination, axiosConfig) {
            await axios
                .post(
                    "/api/property?page=" + this.current_pagination_page,
                    pagination,
                    axiosConfig
                )
                .then((res) => {
                    if (res.data.status === "Success") {
                        this.properties = res.data.data.property;
                        pagination = res.data.data.property;
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        async addProperty(property_form_data_value, axiosConfig) {
            NProgress.start();
            let selected_amenities_id = [];
            _.forEach(property_form_data_value.amenity_id, (value) => {
                selected_amenities_id.push(value.id);
            });
            await axios
                .post(
                    "/api/property/create",
                    {
                        name: property_form_data_value.name,
                        details: property_form_data_value.details,
                        address: property_form_data_value.address,
                        type: property_form_data_value.type.id,
                        size: property_form_data_value.size,
                        amenity_id: selected_amenities_id,
                        brochure: property_form_data_value.brochure,
                    },
                    axiosConfig
                )
                .then((response) => {
                    if (response["data"]["status"] == "Error") {
                        if (response["data"]["data"].length > 0) {
                            toastr.error(
                                response["data"]["data"].join("</br>"),
                                "Error"
                            );
                        } else {
                            toastr.error(response["data"]["message"], "Error");
                        }
                    } else {
                        toastr.success(response["data"]["message"], "Success");
                    }
                })
                .catch((e) => {
                    if (e.response.status === 401) {
                        toastr.error(e.response.data.message, "Error");
                    }
                })
                .then(() => {
                    NProgress.done();
                });
        },
        async getPropertyDetail(property_id, axiosConfig) {
            await axios
                .get(`/api/property/view/${property_id}`, axiosConfig)
                .then((res) => {
                    if (res.data.status === "Success") {
                        let data = res.data.data.property_detail;

                        let type_data =
                            data.type == "residential"
                                ? {
                                      id: "residential",
                                      name: "Residential",
                                  }
                                : {
                                      id: "commercial",
                                      name: "Commercial",
                                  };
                        this.update_property_form_data.name = data.name;
                        this.update_property_form_data.details = data.details;
                        this.update_property_form_data.type = type_data;
                        this.update_property_form_data.size = data.size;
                        this.update_property_form_data.address = data.address;
                        this.update_property_form_data.amenity_id =
                            data.amenities;
                        this.pdf_file =
                            "http://127.0.0.1:8000/storage/proprties/brochure/" +
                            data.id +
                            "/" +
                            data.brochure;
                    }
                })
                .catch((e) => {
                    if (e.response.status === 401) {
                        toastr.error(e.response.data.message, "Error");
                    }
                });
        },
        async updateProperty(
            property_id,
            property_form_data_value,
            axiosConfig
        ) {
            NProgress.start();
            let selected_amenities_id = [];
            _.forEach(property_form_data_value.amenity_id, (value) => {
                selected_amenities_id.push(value.id);
            });
            await axios
                .post(
                    `http://127.0.0.1:8000/api/property/edit/${property_id}`,
                    {
                        name: property_form_data_value.name,
                        details: property_form_data_value.details,
                        address: property_form_data_value.address,
                        type: property_form_data_value.type.id,
                        size: property_form_data_value.size,
                        amenity_id: selected_amenities_id,
                        brochure: property_form_data_value.brochure,
                    },
                    axiosConfig
                )
                .then((response) => {
                    if (response["data"]["status"] == "Error") {
                        if (response["data"]["data"].length > 0) {
                            toastr.error(
                                response["data"]["data"].join("</br>"),
                                "Error"
                            );
                        } else {
                            toastr.error(response["data"]["message"], "Error");
                        }
                    } else {
                        toastr.success(response["data"]["message"], "Success");
                    }
                })
                .catch((e) => {
                    if (e.response.status === 401) {
                        toastr.error(e.response.data.message, "Error");
                    }
                })
                .then(() => {
                    NProgress.done();
                });
        },
        async deleteProperty(property_id, axiosConfig) {
            NProgress.start();
            await axios
                .delete(`api/property/delete/${property_id}`, axiosConfig)
                .then((response) => {
                    if (response["data"]["status"] == "Error") {
                        if (response["data"]["data"].length > 0) {
                            toastr.error(
                                response["data"]["data"].join("</br>"),
                                "Error"
                            );
                        } else {
                            toastr.error(response["data"]["message"], "Error");
                        }
                    } else {
                        toastr.success(response["data"]["message"], "Success");
                        setTimeout(() => {
                            this.removeDeletedProperty(property_id);
                        }, 100);
                    }
                })
                .catch((e) => {
                    console.log(e);
                })
                .then(() => {
                    NProgress.done();
                });
        },
        async getAminityList(axiosConfig) {
            await axios
                .get("/api/property/amenity", axiosConfig)
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.amenities = res.data.data.amenity;
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        removeDeletedProperty(deleted_property_id) {
            if (deleted_property_id) {
                let found_index = _.findIndex(this.properties.data, (o) => {
                    return o.id === deleted_property_id;
                });
                if (found_index >= 0) {
                    this.properties.data.splice(found_index, 1);
                }
            }
        },
    },
});
