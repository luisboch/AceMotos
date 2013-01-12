(function () {
    if (window.google && google.gears) {
        return
    }
    var a = null;
    if (typeof GearsFactory != "undefined") {
        a = new GearsFactory()
    } else {
        try {
            a = new ActiveXObject("Gears.Factory");
            if (a.getBuildInfo().indexOf("ie_mobile") != -1) {
                a.privateSetGlobalObject(this)
            }
        } catch (b) {
            if ((typeof navigator.mimeTypes != "undefined") && navigator.mimeTypes["application/x-googlegears"]) {
                a = document.createElement("object");
                a.style.display = "none";
                a.width = 0;
                a.height = 0;
                a.type = "application/x-googlegears";
                document.documentElement.appendChild(a)
            }
        }
    }
    if (!a) {
        return
    }
    if (!window.google) {
        window.google = {}
    }
    if (!google.gears) {
        google.gears = {factory:a}
    }
})();
(function (e, b, c, d) {
    var f = {};

    function a(h, j, l) {
        var g, i, k, n;
        i = google.gears.factory.create("beta.canvas");
        try {
            i.decode(h);
            if (!j.width) {
                j.width = i.width
            }
            if (!j.height) {
                j.height = i.height
            }
            n = Math.min(width / i.width, height / i.height);
            if (n < 1 || (n === 1 && l === "image/jpeg")) {
                i.resize(Math.round(i.width * n), Math.round(i.height * n));
                if (j.quality) {
                    return i.encode(l, {quality:j.quality / 100})
                }
                return i.encode(l)
            }
        } catch (m) {
        }
        return h
    }

    c.runtimes.Gears = c.addRuntime("gears", {getFeatures:function () {
        return{dragdrop:true, jpgresize:true, pngresize:true, chunks:true, progress:true, multipart:true, multi_selection:true}
    }, init:function (k, m) {
        var l, h, g = false;
        if (!e.google || !google.gears) {
            return m({success:false})
        }
        try {
            l = google.gears.factory.create("beta.desktop")
        } catch (j) {
            return m({success:false})
        }
        function i(p) {
            var o, n, q = [], r;
            for (n = 0; n < p.length; n++) {
                o = p[n];
                r = c.guid();
                f[r] = o.blob;
                q.push(new c.File(r, o.name, o.blob.length))
            }
            k.trigger("FilesAdded", q)
        }

        k.bind("PostInit", function () {
            var o = k.settings, n = b.getElementById(o.drop_element);
            if (n) {
                c.addEvent(n, "dragover", function (p) {
                    l.setDropEffect(p, "copy");
                    p.preventDefault()
                }, k.id);
                c.addEvent(n, "drop", function (q) {
                    var p = l.getDragData(q, "application/x-gears-files");
                    if (p) {
                        i(p.files)
                    }
                    q.preventDefault()
                }, k.id);
                n = 0
            }
            c.addEvent(b.getElementById(o.browse_button), "click", function (t) {
                var s = [], q, p, r;
                t.preventDefault();
                if (g) {
                    return
                }
                no_type_restriction:for (q = 0; q < o.filters.length; q++) {
                    r = o.filters[q].extensions.split(",");
                    for (p = 0; p < r.length; p++) {
                        if (r[p] === "*") {
                            s = [];
                            break no_type_restriction
                        }
                        s.push("." + r[p])
                    }
                }
                l.openFiles(i, {singleFile:!o.multi_selection, filter:s})
            }, k.id)
        });
        k.bind("CancelUpload", function () {
            if (h.abort) {
                h.abort()
            }
        });
        k.bind("UploadFile", function (t, q) {
            var v = 0, u, r, s = 0, p = t.settings.resize, n;
            if (p && /\.(png|jpg|jpeg)$/i.test(q.name)) {
                f[q.id] = a(f[q.id], p, /\.png$/i.test(q.name) ? "image/png" : "image/jpeg")
            }
            q.size = f[q.id].length;
            r = t.settings.chunk_size;
            n = r > 0;
            u = Math.ceil(q.size / r);
            if (!n) {
                r = q.size;
                u = 1
            }
            function o() {
                var B, x = t.settings.multipart, w = 0, A = {name:q.target_name || q.name}, y = t.settings.url;

                function z(D) {
                    var C, I = "----pluploadboundary" + c.guid(), F = "--", H = "\r\n", E, G;
                    if (x) {
                        h.setRequestHeader("Content-Type", "multipart/form-data; boundary=" + I);
                        C = google.gears.factory.create("beta.blobbuilder");
                        c.each(c.extend(A, t.settings.multipart_params), function (K, J) {
                            C.append(F + I + H + 'Content-Disposition: form-data; name="' + J + '"' + H + H);
                            C.append(K + H)
                        });
                        G = c.mimeTypes[q.name.replace(/^.+\.([^.]+)/, "$1").toLowerCase()] || "application/octet-stream";
                        C.append(F + I + H + 'Content-Disposition: form-data; name="' + t.settings.file_data_name + '"; filename="' + q.name + '"' + H + "Content-Type: " + G + H + H);
                        C.append(D);
                        C.append(H + F + I + F + H);
                        E = C.getAsBlob();
                        w = E.length - D.length;
                        D = E
                    }
                    h.send(D)
                }

                if (q.status == c.DONE || q.status == c.FAILED || t.state == c.STOPPED) {
                    return
                }
                if (n) {
                    A.chunk = v;
                    A.chunks = u
                }
                B = Math.min(r, q.size - (v * r));
                if (!x) {
                    y = c.buildUrl(t.settings.url, A)
                }
                h = google.gears.factory.create("beta.httprequest");
                h.open("POST", y);
                if (!x) {
                    h.setRequestHeader("Content-Disposition", 'attachment; filename="' + q.name + '"');
                    h.setRequestHeader("Content-Type", "application/octet-stream")
                }
                c.each(t.settings.headers, function (D, C) {
                    h.setRequestHeader(C, D)
                });
                h.upload.onprogress = function (C) {
                    q.loaded = s + C.loaded - w;
                    t.trigger("UploadProgress", q)
                };
                h.onreadystatechange = function () {
                    var C;
                    if (h.readyState == 4 && t.state !== c.STOPPED) {
                        if (h.status == 200) {
                            C = {chunk:v, chunks:u, response:h.responseText, status:h.status};
                            t.trigger("ChunkUploaded", q, C);
                            if (C.cancelled) {
                                q.status = c.FAILED;
                                return
                            }
                            s += B;
                            if (++v >= u) {
                                q.status = c.DONE;
                                t.trigger("FileUploaded", q, {response:h.responseText, status:h.status})
                            } else {
                                o()
                            }
                        } else {
                            t.trigger("Error", {code:c.HTTP_ERROR, message:c.translate("HTTP Error."), file:q, chunk:v, chunks:u, status:h.status})
                        }
                    }
                };
                if (v < u) {
                    z(f[q.id].slice(v * r, B))
                }
            }

            o()
        });
        k.bind("DisableBrowse", function (n, o) {
            g = o
        });
        k.bind("Destroy", function (n) {
            var o, p, q = {browseButton:n.settings.browse_button, dropElm:n.settings.drop_element};
            for (o in q) {
                p = b.getElementById(q[o]);
                if (p) {
                    c.removeAllEvents(p, n.id)
                }
            }
        });
        m({success:true})
    }})
})(window, document, plupload);