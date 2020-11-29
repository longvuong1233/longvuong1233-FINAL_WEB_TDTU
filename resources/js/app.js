import axios from "axios";

const myaxios = axios.create({
    baseURL: window.location.protocol + "//" + window.location.host,
    timeout: 1000
});

var app = new Vue({
    el: "#headerLayout",
    data: {
        codeClass: "",
        nameClass: "",
        partClass: "",
        titleClass: "",
        roomNumber: ""
    },
    methods: {
        submitJoin(event) {
            let code = this.codeClass.trim();
            if (code == "") {
                event.preventDefault();
            }
        },
        submitCreate(event) {
            let nameClass = this.nameClass.trim();
            let partClass = this.partClass.trim();
            let titleClass = this.titleClass.trim();
            let roomNumber = this.roomNumber.trim();

            if (
                nameClass == "" ||
                partClass == "" ||
                titleClass == "" ||
                roomNumber == ""
            ) {
                event.preventDefault();
            }
        }
    }
});

var app2 = new Vue({
    el: "#streamClassroom",
    data: {
        content: "hadinh",
        listComment: [],
        comment: ""
    },
    filters: {
        datetimeFormat(datetime) {
            let date = new Date(Date.parse(datetime));
            let day = date.getDate();
            let month = parseInt(date.getMonth()) + 1;
            let year = date.getFullYear();
            let hours = date.getHours();
            let m = date.getMinutes();
            let second = date.getSeconds();
            let minute = parseInt(m) < 10 ? "0" + m : m;

            return `${hours}:${minute}:${second} - ${day}/${month}/${year}`;
        }
    },
    methods: {
        checkPemission(userId, userRole, comment) {
            if (
                userRole == "admin" ||
                userRole == "teacher" ||
                comment.owner == userId
            ) {
                return true;
            }
            return false;
        },
        getComment(idClass, idStatus) {
            myaxios
                .get("/commentClass", {
                    params: {
                        id_class: idClass,
                        id_status: idStatus
                    }
                })
                .then(response => {
                    this.listComment = response.data.slice();
                });
        },
        leaveComment(idClass, idStatus) {
            myaxios
                .post("commentClass", {
                    id_class: idClass,
                    id_status: idStatus,
                    comment: this.comment
                })
                .then(response => {
                    if (response.status == 200) {
                        this.getComment(
                            response.data.id_class,
                            response.data.id_status
                        );
                        this.comment = "";
                    }
                });
        },
        deleteComment(id) {
            myaxios
                .delete("commentClass", {
                    params: {
                        id_comment: id
                    }
                })
                .then(response => {
                    if (response.status == 200) {
                        this.getComment(
                            response.data.id_class,
                            response.data.id_status
                        );
                    }
                });
        }
    }
});

var app3 = new Vue({
    el: "#detailsStatusClassroom",
    data: {
        listComment: [],
        displayComment: false,
        comment: ""
    },
    filters: {
        datetimeFormat(datetime) {
            let date = new Date(Date.parse(datetime));
            let day = date.getDate();
            let month = parseInt(date.getMonth()) + 1;
            let year = date.getFullYear();
            let hours = date.getHours();
            let m = date.getMinutes();
            let second = date.getSeconds();
            let minute = parseInt(m) < 10 ? "0" + m : m;
            return `${hours}:${minute}:${second} - ${day}/${month}/${year}`;
        }
    },

    methods: {
        submitAssignmentAgain(event) {
            let cf = confirm(
                "Your all files submited last time will delete!!!"
            );
            if (cf == false) {
                event.preventDefault();
            }
        },
        confirmSubmitDelete(event) {
            let cf = confirm("Are You Sure ??");
            if (cf == false) {
                event.defaultPrevented();
            }
        },
        onclick(idClass, idStatus) {
            this.displayComment = !this.displayComment;
            this.getComment(idClass, idStatus);
        },
        getComment(idClass, idStatus) {
            if (this.displayComment == true) {
                myaxios
                    .get("/commentClass", {
                        params: {
                            id_class: idClass,
                            id_status: idStatus
                        }
                    })
                    .then(response => {
                        this.listComment = response.data.slice();
                    });
            }
        },
        leaveComment(idClass, idStatus) {
            myaxios
                .post("commentClass", {
                    id_class: idClass,
                    id_status: idStatus,
                    comment: this.comment
                })
                .then(response => {
                    if (response.status == 200) {
                        this.getComment(
                            response.data.id_class,
                            response.data.id_status
                        );

                        this.comment = "";
                    }
                });
        },
        deleteComment(id) {
            myaxios
                .delete("commentClass", {
                    params: {
                        id_comment: id
                    }
                })
                .then(response => {
                    if (response.status == 200) {
                        this.getComment(
                            response.data.id_class,
                            response.data.id_status
                        );
                    }
                });
        }
    }
});

var app4 = new Vue({
    el: "#headerClassroom",
    data: {},
    methods: {
        deleteClass(event) {
            let cf = confirm("This class will delete!!!!");
            if (cf == false) {
                event.preventDefault();
            }
        }
    }
});

var app5 = new Vue({
    el: "#findClassroom",
    data: {
        id: "",
        name: "",
        part: "",
        title: "",
        room: "",
        listClass: [],
        listFindClass: [],
        find: false
    },
    methods: {
        updateClassroom(index) {
            let cf = confirm("This Information Class will change");
            if (cf == true) {
                myaxios
                    .patch("/classroomapi/" + this.listClass[index].id, {
                        nameclass: this.listClass[index].nameclass,
                        part: this.listClass[index].part,
                        title: this.listClass[index].title,
                        room: this.listClass[index].room
                    })
                    .then(response => {
                        this.listClass = [...response.data];
                    });
            }
        },
        deleteClassroom(index) {
            let cf = confirm("This Class will delete");
            if (cf == true) {
                myaxios
                    .delete("/classroomapi/" + this.listClass[index].id)
                    .then(response => {
                        this.listClass = [...response.data];
                    });
            }
        },
        setArrayListFindClass() {
            this.listFindClass = this.listClass.filter(ele => {
                return (
                    ele.id.match(this.id) &&
                    ele.nameclass.match(this.name) &&
                    ele.part.match(this.part) &&
                    ele.title.match(this.title) &&
                    ele.room.match(this.room)
                );
            });
        }
    },

    created() {
        myaxios.get("/classroom").then(response => {
            console.log(response.data)
            this.listClass = [...response.data];
        });
    },

    watch: {
        find(newValue) {
            if (newValue == true) {
                this.listFindClass = [...this.listClass];
            }
        },
        name(newValue) {
            if (this.find == true) {
                this.setArrayListFindClass();
            }
        },
        part(newValue) {
            if (this.find == true) {
                this.setArrayListFindClass();
            }
        },
        title(newValue) {
            if (this.find == true) {
                this.setArrayListFindClass();
            }
        },
        room(newValue) {
            if (this.find == true) {
                this.setArrayListFindClass();
            }
        },
        id(newValue) {
            if (this.find == true) {
                this.setArrayListFindClass();
            }
        }
    }
});

var app6 = new Vue({
    el: "#peopleClassroom",
    methods: {
        submitDelete(event) {
            let cf = confirm("This user will get out!!!");
            if (cf == false) {
                event.preventDefault();
            }
        }
    }
});