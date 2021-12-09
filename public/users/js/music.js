$(document).ready(function () {
    fetch(
        "https://api.apify.com/v2/key-value-stores/EJ3Ppyr2t73Ifit64/records/LATEST"
    )
        .then((res) => res.json())
        .then((res) => {
            const TOP_100 = res.songs.top100_VN;
            toastr["success"]("Load dữ liệu thành công.", "Thành công");

            let typeSong = TOP_100.map(function (type, index) {
                return `<option value="${index}">${type.name}</option>`;
            });
            $(".type-song").append(typeSong);

            let songs = TOP_100[0].songs;
            let listSong = songs.map(function (song, index) {
                return `<div>
                 <li class="song song${index}" data-id="${index}">${index + 1}. ${song.title}</li>
                  <a href="${
                      song.url
                  }" target="_blank" ><i class="fas fa-eye"></i></a>
                  <a href="${song.music}"><i class="fas fa-download"></i></a>
                 </div>`;
            });
            $("#songs").html(listSong);

            $(document).on("change", ".type-song", function (e) {
                const type = $(this).val();
                songs = TOP_100[type].songs;
                listSong = songs.map(function (song, index) {
                    return `<div>
                            <li class="song song${index}" data-id="${index}">${index + 1}. ${song.title}</li>
                            <a href="${
                                song.url
                            }" target="_blank" ><i class="fas fa-eye"></i></i></a>
                            <a href="${
                                song.music
                            }" ><i class="fas fa-download"></i></a>
                         </div>`;
                });

                $("#songs").html(listSong);
            });

            let audio,
                currSong = -1;

            let bgSong = $("#bg-song"),
                singerSong = $("#singer-song"),
                titleSong = $("#title-song"),
                playNext = $("#play-next"),
                playPrevious = $("#play-previous"),
                playPauseButton = $("#play-pause-button"),
                i = playPauseButton.find("i");

            function playChoose(index) {
                titleSong.text(songs[currSong].title);
                singerSong.text(songs[currSong].creator);
                bgSong.attr("src", songs[currSong].avatar);
                audio.src = songs[currSong].music;
                document.title = songs[currSong].title;
            }

            $(document).on("click", ".song", function () {
                const song = $(this);
                const index = song.data("id");

                $(".song").removeClass("active-song");
                song.addClass("active-song");

                currSong = index;
                playChoose(index);
                i.attr("class", "fa fa-pause");
                audio.play();
            });

            function playPause() {
                setTimeout(function () {
                    if (audio.paused) {
                        i.attr("class", "fas fa-pause");
                        audio.play();
                    } else {
                        i.attr("class", "fas fa-play");
                        audio.pause();
                    }
                }, 300);
            }

            function selectTrack(flag) {
                if (flag == 0 || flag == 1) currSong++;
                else currSong--;

                if (currSong >= songs.length || currSong < 0) {
                    currSong = 0;
                }

                bgSong.attr("src", songs[currSong].bgImage);

                playChoose(currSong);

                if (flag != 0) {
                    audio.play();
                    i.attr("class", "fa fa-pause");
                }
                if (flag == 0) i.attr("class", "fa fa-play");

                $(".song").removeClass("active-song");
                $(`.song${currSong}`).addClass("active-song");
            }

            function initPlayer() {
                audio = new Audio();
                audio.loop = false;

                selectTrack(0);
                playPauseButton.on("click", playPause);

                playNext.click(function () {
                    selectTrack(1);
                });

                playPrevious.click(function () {
                    selectTrack(-1);
                });
            }

            initPlayer();
        });

    // const TOP_100 = [
    //     {
    //         name: "Nhạc Trẻ",
    //         url: "https://nhaccuatui.com",
    //         songs: [
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/12/e/2/9/e/1615554946033.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/07/13/0/6/d/2/1626145766324_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phúc Chinh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/22/2/8/d/4/1616360845396.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1012/TheLuong-PhucChinh-6971140.mp3?st=nEd9QKrDPq7PGNbD-zxdEw&e=1626319087",
    //                 title: "Thê Lương",
    //                 url: "https://www.nhaccuatui.com/bai-hat/the-luong-phuc-chinh.nmxw6tXZyBQy.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/04/29/9/1/f/8/1619691182261.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/05/12/7/d/c/b/1620802736418_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Sơn Tùng M-TP",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/05/07/a/9/f/2/1620357842616.lrc",
    //                 music: "https://aredir.nixcdn.com/Believe_Audio19/MuonRoiMaSaoCon-SonTungMTP-7011803.mp3?st=uPqHA1vdgUDNNYcvqr2oaA&e=1626319087",
    //                 title: "Muộn Rồi Mà Sao Còn",
    //                 url: "https://www.nhaccuatui.com/bai-hat/muon-roi-ma-sao-con-son-tung-m-tp.6nAqBAZ3nxuV.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/07/03/e/9/6/f/1625303286239.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/07/05/7/5/8/a/1625467381647_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Kay Trần",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/07/10/2/9/b/8/1625892644539.lrc",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/NamDoiBanTay-KayTran-7042104.mp3?st=6pYOfWWdl4U4kGfONAqM2A&e=1626319087",
    //                 title: "Nắm Đôi Bàn Tay",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nam-doi-ban-tay-kay-tran.xcNnXdzdGWuz.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/05/30/2/6/7/5/1622365032910.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/29/3/c/a/6/1624943867794_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "JSOL, Hoàng Duyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/SaiGonHomNayMua-JSOLHoangDuyen-7026537.mp3?st=f16ipo_DAUCt5IrH0ROdYQ&e=1626319087",
    //                 title: "Sài Gòn Hôm Nay Mưa",
    //                 url: "https://www.nhaccuatui.com/bai-hat/sai-gon-hom-nay-mua-jsol-ft-hoang-duyen.EZwfyBx9IT1N.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/27/d/2/9/1/1616859493571.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/03/30/c/2/0/6/1617079270471_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hứa Kim Tuyền, Hoàng Duyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/29/0/3/e/5/1616991024586.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1013/SaiGonDauLongQua-HuaKimTuyenHoangDuyen-6992977.mp3?st=x1GxaN-Lghaa7kTWfv-wnA&e=1626319087",
    //                 title: "Sài Gòn Đau Lòng Quá",
    //                 url: "https://www.nhaccuatui.com/bai-hat/sai-gon-dau-long-qua-hua-kim-tuyen-ft-hoang-duyen.2hI4xFTa2lxJ.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/28/8/4/3/c/1624872522478.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/03/15/4/7/7/8/1615802750962_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "X2X",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/07/08/6/e/d/5/1625714895877.lrc",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/TracTro-X2X-7040184.mp3?st=tET44tS3Z9zaQBHOU0TT0w&e=1626319087",
    //                 title: "Trắc Trở",
    //                 url: "https://www.nhaccuatui.com/bai-hat/trac-tro-x2x.euuuwjUAqLcX.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/04/14/c/3/3/b/1618383513976.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/04/14/b/9/8/b/1618374024681_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phát Huy T4, Truzg",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/04/19/b/1/b/6/1618802396072.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1014/PhanDuyenLoLang-PhatHuyT4Trugz-7004538.mp3?st=cmeoDQ2Flg2sr29js9adFw&e=1626319087",
    //                 title: "Phận Duyên Lỡ Làng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/phan-duyen-lo-lang-phat-huy-t4-ft-truzg.ipBDxxA22NUf.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/18/d/c/e/c/1623989997901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/02/c/4/b/1/1604299335097_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hương Ly",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/NeuCoKiepSau-HuongLy-7034940.mp3?st=cBOUKw70kk42JBLtL_FN8Q&e=1626319087",
    //                 title: "Nếu Có Kiếp Sau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/neu-co-kiep-sau-huong-ly.ERV3kZbvf716.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/25/0/b/f/e/1616662504016.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/12/14/2/5/3/b/1607910088022_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Anh Rồng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/31/f/4/c/b/1617161486413.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1013/VachNgocNga-AnhRong-6984991.mp3?st=LbscIMZoVMQvxKN5QOr8iQ&e=1626319087",
    //                 title: "Vách Ngọc Ngà",
    //                 url: "https://www.nhaccuatui.com/bai-hat/vach-ngoc-nga-anh-rong.Rk1SNs5dI0Nf.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/07/31/c/5/8/9/1596188259603.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/19/1/e/f/8/1568871085871_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hoàng Dũng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/08/04/a/7/a/5/1596551789790.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1001/NangTho-HoangDung-6413381.mp3?st=7lqH8RvKNIOvmqekiTRViw&e=1626319087",
    //                 title: "Nàng Thơ",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nang-tho-hoang-dung.Kx3Kbih0rS5z.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/11/05/4/4/6/c/1604574284072.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/05/2/2/0/3/1604563630516_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "MIN",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/11/05/9/5/c/9/1604562096053.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1005/TrenTinhBanDuoiTinhYeu-MIN-6802163.mp3?st=_2rEAKiDlRhGhq9Td0KiJA&e=1626319087",
    //                 title: "Trên Tình Bạn Dưới Tình Yêu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tren-tinh-ban-duoi-tinh-yeu-min.adEZfVuRfAhW.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/29/2/2/1/e/1617029681297.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/09/22/5/3/5/d/1600744344048_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Đình Dũng, ACV",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/04/05/9/f/3/8/1617596589191.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1013/CauHenCauThe-DinhDung-6994741.mp3?st=sn5VtOQm53HxCLjMX9d94A&e=1626319087",
    //                 title: "Câu Hẹn Câu Thề",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cau-hen-cau-the-dinh-dung-ft-acv.DT1Ev3vytaQo.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/07/06/7/a/3/0/1625546620298.jpg",
    //                 bgImage: "",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Changg, Minh Huy",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/EmKhongHieu-ChanggMinhHuy-7043556.mp3?st=MAwB0EIzJ33fQNVoHFmGeA&e=1626319087",
    //                 title: "Em Không Hiểu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/em-khong-hieu-changg-ft-minh-huy.gWRtS5SiJInk.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/02/10/6/5/a/6/1612954164434.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/02/17/a/3/2/1/1613561860337_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Juky San, RedT",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/08/5/c/4/b/1615219017101.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1011/PhaiChangEmDaYeu-JukySanRedT-6940932.mp3?st=7iX3YWIU9m5X1Jxk3ciA2w&e=1626319087",
    //                 title: "Phải Chăng Em Đã Yêu?",
    //                 url: "https://www.nhaccuatui.com/bai-hat/phai-chang-em-da-yeu-juky-san-ft-redt.MRUP1c69kN0R.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/01/21/5/c/9/9/1611199600529.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/11/08/2/2/a/0/1573196340329_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Lemese, Changg",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/08/5/c/4/b/1615219651901.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1010/LoSayByeLaBye-LemeseChangg-6926941.mp3?st=gaK37RnI4LWtlivT9YcCLA&e=1626319087",
    //                 title: "Lỡ Say Bye Là Bye",
    //                 url: "https://www.nhaccuatui.com/bai-hat/lo-say-bye-la-bye-lemese-ft-changg.QLdwL2NxwFA5.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/01/27/5/2/2/b/1611738358661.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/08/12/f/2/d/1/1597199590443_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "T.R.I",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/08/5/c/4/b/1615219421510.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1010/ChungTaSauNay-TRI-6929586.mp3?st=UjOpc48tSNvkviwS25h9tg&e=1626319087",
    //                 title: "Chúng Ta Sau Này",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chung-ta-sau-nay-tri.61Wkf72FX7be.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/10/12/0/7/e/3/1602477673421.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/02/c/4/b/1/1604299335097_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hương Ly",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/10/13/7/4/f/8/1602557634151.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1004/TheThai-HuongLy-6728509.mp3?st=-Er2GMdd1wIBsFLOKUzatA&e=1626319087",
    //                 title: "Thế Thái",
    //                 url: "https://www.nhaccuatui.com/bai-hat/the-thai-huong-ly.73T5LuURl5Bo.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/12/07/e/7/5/9/1607308157174.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/01/24/a/3/d/e/1516765405718_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Lê Bảo Bình",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/12/09/c/7/2/e/1607480641266.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1008/NiuDuyen-LeBaoBinh-6872127.mp3?st=We6RSbAxTTkZOi3H1Nlb4Q&e=1626319087",
    //                 title: "Níu Duyên",
    //                 url: "https://www.nhaccuatui.com/bai-hat/niu-duyen-le-bao-binh.WxXR1SGXHAR7.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/04/19/d/1/f/1/1618810475930.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/05/24/8/d/6/e/1621842906046_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phí Phương Anh, RIN9",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/04/26/e/3/9/0/1619429354101.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1014/RangKhon-PhiPhuongAnhTheFaceRIN9-7006388.mp3?st=rqQ3tq8uCB3uhsScIQHTLw&e=1626319087",
    //                 title: "Răng Khôn",
    //                 url: "https://www.nhaccuatui.com/bai-hat/rang-khon-phi-phuong-anh-ft-rin9.DS5NwsGBlUhU.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/01/07/6/a/b/e/1610006675703.jpg",
    //                 bgImage: "",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hồ Văn Quý, Xám",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/08/5/c/4/b/1615218817951.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1009/TinhYeuMauHong-HoVanQuyXam-6914636.mp3?st=mm4KnpxrXZA1KgSX_wyrDQ&e=1626319087",
    //                 title: "Tình Yêu Màu Hồng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tinh-yeu-mau-hong-ho-van-quy-ft-xam.eJ4UnTgbMGlM.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/09/28/4/9/a/7/1601278894694.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/09/22/5/3/5/d/1600744344048_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Đình Dũng, ACV",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/10/05/3/5/9/1/1601871124164.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1004/AnhKhongThaThu-DinhDung-6684271.mp3?st=YEHkAHpxgOdnQOnUH1fHCA&e=1626319087",
    //                 title: "Anh Không Tha Thứ",
    //                 url: "https://www.nhaccuatui.com/bai-hat/anh-khong-tha-thu-dinh-dung-ft-acv.CE7Fwqox7j2h.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/07/02/5/d/c/9/1593687560557.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/16/6/5/0/2/1605520530526_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Bùi Trường Linh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/08/25/d/a/e/d/1598338850508.lrc",
    //                 music: "https://aredir.nixcdn.com/Unv_Audio164/DuongTaChoEmVe-buitruonglinh-6318765.mp3?st=PLo4bKK-CkDhYdG9mDr-bg&e=1626319087",
    //                 title: "Đường Tôi Chở Em Về",
    //                 url: "https://www.nhaccuatui.com/bai-hat/duong-toi-cho-em-ve-bui-truong-linh.EEZTcFO2Ajfc.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/07/06/7/a/3/0/1625565778156.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/07/22/f/1/f/9/1595390874021_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Xesi, Ricky Star",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/Dam-XesiRickyStar-7043873.mp3?st=jTpIQBrswt4_tswErFRiZg&e=1626319087",
    //                 title: "Đắm",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dam-xesi-ft-ricky-star.5CpnEWPAF1G9.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/18/d/c/e/c/1623997610871.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/28/b/2/0/9/1624860911842_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Wren Evans",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/Unv_Audio198/ThichEmHoiNhieu-WrenEvans-7034969.mp3?st=wr3oWIS6wJxA4zSAyw7l3A&e=1626319087",
    //                 title: "Thích Em Hơi Nhiều",
    //                 url: "https://www.nhaccuatui.com/bai-hat/thich-em-hoi-nhieu-wren-evans.kUOJILsq8CmU.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/30/7/5/6/a/1625044639680.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/02/25/0/a/4/a/1614246198439_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Jang Mi",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/07/08/6/e/d/5/1625711449362.lrc",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/DanhPhan-JangMi-7040679.mp3?st=1ZxfmadAqMzz-GpRjMbA4A&e=1626319087",
    //                 title: "Danh Phận",
    //                 url: "https://www.nhaccuatui.com/bai-hat/danh-phan-jang-mi.eKLIGmTuae4Y.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/05/26/a/4/3/5/1622010601718.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/28/b/2/0/9/1624861449651_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Bích Phương, 1989s Entertainment",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/DoAnhDoanDuoc-BichPhuong1989sEntertainment-7024661.mp3?st=qJj15tfZ2PY-NMgHGxr7mQ&e=1626319087",
    //                 title: "Đố Anh Đoán Được",
    //                 url: "https://www.nhaccuatui.com/bai-hat/do-anh-doan-duoc-bich-phuong-ft-1989s-entertainment.vFSEX3eiczQU.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/25/e/6/6/d/1624587056202.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/16/6/5/0/2/1605520530526_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Bùi Trường Linh, Freak D",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/DuongToiChoEmVeLofiVersion-buitruonglinhFreakD-7025960.mp3?st=dw-c95KdKf0GtoPhWU8MFg&e=1626319087",
    //                 title: "Đường Tôi Chở Em Về (Lofi Version)",
    //                 url: "https://www.nhaccuatui.com/bai-hat/duong-toi-cho-em-ve-lofi-version-bui-truong-linh-ft-freak-d.cNZNdDIbq1va.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/05/d/9/5/e/1567670108816.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/05/d/9/5/e/1567670108816_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Soobin Hoàng Sơn, SlimV",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/ThangNamSpecialPerformance-SoobinHoangSonSlimV-7020121.mp3?st=EOmLcB5FXQoiPoflWKyWEg&e=1626319087",
    //                 title: "Tháng Năm (Special Performance)",
    //                 url: "https://www.nhaccuatui.com/bai-hat/thang-nam-special-performance-soobin-hoang-son-ft-slimv.IwPyhctfVIP7.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/05/22/f/1/c/b/1621648577854.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590565041302_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Khắc Việt",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/05/23/a/2/b/3/1621748119011.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/HienDai-KhacViet-7022864.mp3?st=2fCeyuwdBSpqk6u-6BznJA&e=1626319087",
    //                 title: "Hiện Đại",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hien-dai-khac-viet.PtjLT1SNRrmn.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/07/09/5/5/8/2/1625830205838.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/29/3/c/a/6/1624943867794_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "JSOL",
    //                 lyric: "",
    //                 music: "https://f9-stream.nixcdn.com/Unv_Audio199/DocThan-JSOL-7045817.mp3?st=4v8TGdbC0kBGOrlyb9hhMg&e=1626319087",
    //                 title: "Độc Thân",
    //                 url: "https://www.nhaccuatui.com/bai-hat/doc-than-jsol.FIlHxVoxvPpb.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/04/01/e/2/b/5/1617248289520.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/06/27/e/8/8/5/1530074198530_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hà Anh Tuấn",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/04/01/8/f/f/4/1617275972934.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1014/ThangMayEmNhoAnh-HaAnhTuan-6995531.mp3?st=y-FB8HsVXy4HsjM1JpaVmQ&e=1626319087",
    //                 title: "Tháng Mấy Em Nhớ Anh?",
    //                 url: "https://www.nhaccuatui.com/bai-hat/thang-may-em-nho-anh-ha-anh-tuan.tV4swZ9ekyZS.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/04/14/b/9/8/b/1618374024681.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/04/14/b/9/8/b/1618374024681_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phát Huy T4",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/DoanTuyetNangDi-PhatHuyT4-7034809.mp3?st=49-OtLMlaWwZuQYSQX5y_A&e=1626319087",
    //                 title: "Đoạn Tuyệt Nàng Đi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/doan-tuyet-nang-di-phat-huy-t4.lHUnJ1XUAD3U.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/17/f/b/d/5/1623919466016.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/29/3/c/a/6/1624943867794_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "JSOL, Hoàng Duyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/06/25/b/9/1/5/1624589446608.lrc",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/SaiGonHomNayMuaLofiRainVersion-JSOLHoangDuyen-7034696.mp3?st=n8bI5Z7azfcxA66_odV50w&e=1626319087",
    //                 title: "Sài Gòn Hôm Nay Mưa (Lofi Rain Version)",
    //                 url: "https://www.nhaccuatui.com/bai-hat/sai-gon-hom-nay-mua-lofi-rain-version-jsol-ft-hoang-duyen.z04Ln7C2xsNK.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/08/7/c/1/b/1623138395417.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/04/06/c/6/7/6/1617694258591_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phát Hồ",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/NguoiConThuongTa-X2X-7030713.mp3?st=gr_qJ5s7vUMlLZ5qf_m0BA&e=1626319087",
    //                 title: "Người Còn Thương Ta",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nguoi-con-thuong-ta-phat-ho.oa8Sc8ZzPbnD.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/18/d/c/e/c/1624002360534.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hoài Lâm",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/HoaNoVoThuong-HoaiLam-7035558.mp3?st=6ovm0ESJnP1-SipxUNBz4g&e=1626319087",
    //                 title: "Hoa Nở Vô Thường",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hoa-no-vo-thuong-hoai-lam.9Qf7HEN8EL49.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/09/b/d/a/0/1623234668765.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/07/22/f/e/a/2/1563760304939_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hoàng Tôn, LyHan",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/TinhYeuNguQuen-HoangTonLyhan-7030537.mp3?st=IjBKYelV4RFQY_AUidJXZw&e=1626319088",
    //                 title: "Tình Yêu Ngủ Quên (Chill Version)",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tinh-yeu-ngu-quen-chill-version-hoang-ton-ft-lyhan.z5k1RIhZ3M4D.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/29/3/c/a/6/1624943867794.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/29/3/c/a/6/1624943867794_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "JSOL, Hoàng Duyên, 1 9 6 7",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/06/25/b/9/1/5/1624591097589.lrc",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/SaiGonHomNayMuaLofiVersion-JSOLHoangDuyen1967-7034643.mp3?st=qxgkL2aUzxVlUSXKiMkp6A&e=1626319088",
    //                 title: "Sài Gòn Hôm Nay Mưa (Lofi Version)",
    //                 url: "https://www.nhaccuatui.com/bai-hat/sai-gon-hom-nay-mua-lofi-version-jsol-ft-hoang-duyen-ft-1-9-6-7.NG5fVJ5qMlmE.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/22/0/3/e/7/1624342801342.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/02/27/f/2/1/c/1582798501233_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Huy Vạc",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/HongTranVuongSauCay-HuyVac-7036434.mp3?st=-TFvAB6XOBdTgZ51nnOB8w&e=1626319088",
    //                 title: "Hồng Trần Vương Sầu Cay",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hong-tran-vuong-sau-cay-huy-vac.a1Sz2F9FKpkO.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/26/c/6/8/0/1624703507463.jpg",
    //                 bgImage: "",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Wind",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/GapNhauBenNhauLaYTroi-Wind-7037709.mp3?st=5K754J5EVDBqVlgtDld16A&e=1626319088",
    //                 title: "Gặp Nhau Bên Nhau Là Ý Trời",
    //                 url: "https://www.nhaccuatui.com/bai-hat/gap-nhau-ben-nhau-la-y-troi-wind.jUYyDGaks4QR.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/08/28/1/a/1/b/1503913422094.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/08/28/1/a/1/b/1503913422094_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tuấn Hưng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2019/04/14/6/b/d/7/1555243499235.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio5/CauVongKhuyet-TuanHung-2557205.mp3?st=u0lnFOF_6OSMxgtVSjo8HQ&e=1626319088",
    //                 title: "Cầu Vồng Khuyết",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cau-vong-khuyet-tuan-hung.hh8YUwYLhJO2.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/06/5/3/8/e/1622957199468.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/12/16/b/e/6/c/1576471397360_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hương Tràm",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/Believe_Audio19/DongTinh-HuongTram-7030223.mp3?st=kktdc363KrwDV3w9NFjohA&e=1626319088",
    //                 title: "Đong Tình",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dong-tinh-huong-tram.p61jbIzp6xH6.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/05/10/d/4/2/9/1620640028319.jpg",
    //                 bgImage: "",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Khả Hiệp",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1015/HenKiepSau-KhaHiep-7017276.mp3?st=cjRupMMBjYC--olLoqC6Xg&e=1626319088",
    //                 title: "Hẹn Kiếp Sau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hen-kiep-sau-kha-hiep.AkLN9TJJ07Qy.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/02/f/2/c/4/1622626209223.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/05/07/7/c/e/5/1525673879571_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hồ Quang Hiếu",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/NuocMatDongBang-HoQuangHieu-7029473.mp3?st=rT01qOyjHkQuLCwW5eLNUQ&e=1626319088",
    //                 title: "Nước Mắt Đóng Băng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nuoc-mat-dong-bang-ho-quang-hieu.3EbWeLFx5wFR.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/11/2/b/b/7/1623387509078.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/10/24/d/0/b/5/1508827650609_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Thảo Wendy",
    //                 lyric: "",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/DonPhuongLaTonThuong-ThaoWendy-7031609.mp3?st=lNJnTAjEzIIwZ9IUIVhPfA&e=1626319088",
    //                 title: "Đơn Phương Là Tổn Thương",
    //                 url: "https://www.nhaccuatui.com/bai-hat/don-phuong-la-ton-thuong-thao-wendy.vOLCPtpxPjBX.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/07/05/0/4/f/4/1625469284189.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453715818225_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Khánh Đơn, Khánh Trung",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/07/08/6/e/d/5/1625705303016.lrc",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/CungMotBauTroi-KhanhDonKhanhTrung-7043210.mp3?st=uvKNwW7bVGtL0ssWtT3ccw&e=1626319088",
    //                 title: "Cùng Một Bầu Trời",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cung-mot-bau-troi-khanh-don-ft-khanh-trung.dHheBZjbHd2k.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/10/e/7/c/a/1623318115857.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/28/b/2/0/9/1624848057424_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Jena, 24D.Bofie",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/MeChuEEE-Jena24DBofie-7031383.mp3?st=2RWkKlv7S6ipWgWT3wqDoA&e=1626319088",
    //                 title: "Mê Chữ Ê Ê Ê",
    //                 url: "https://www.nhaccuatui.com/bai-hat/me-chu-e-e-e-jena-ft-24dbofie.3wiVu2Rc1xbp.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/03/6/0/a/8/1622703188383.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/11/07/3/8/1/0/1573113563975_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Suni Hạ Linh, Dế Choắt, Hoàng Dũng",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/NoiLoiHienNhien-SuniHaLinhDeChoatHoangDungTheVoice-7029654.mp3?st=0IDTysqMWJd4nyq4Qn_hpA&e=1626319088",
    //                 title: "Nói Lời Hiển Nhiên",
    //                 url: "https://www.nhaccuatui.com/bai-hat/noi-loi-hien-nhien-suni-ha-linh-ft-de-choat-ft-hoang-dung.LxHvrXKJwOFD.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/11/2/b/b/7/1623394762771.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/10/13/2/7/9/e/1602579084994_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tuấn Hii",
    //                 lyric: "",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/NguoiThuongThuongNguoi-TuanHii-7031654.mp3?st=8cwC9P2UOItf1cXOrLHEJw&e=1626319088",
    //                 title: "Người Thương Thương Người",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nguoi-thuong-thuong-nguoi-tuan-hii.MKSqecoXv2mJ.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/16/1/a/6/3/1623822616413.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/07/05/5/8/b/f/1562300922090_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phương Anh, Thằng Bờm",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/EmLaHoaCoGai-PhuongAnhIdol-7034384.mp3?st=ON5hhUTCqFCx_-syJxVcLQ&e=1626319088",
    //                 title: "Em Là Hoa Có Gai",
    //                 url: "https://www.nhaccuatui.com/bai-hat/em-la-hoa-co-gai-phuong-anh-ft-thang-bom.7EnAhjUvqIVf.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/10/e/7/c/a/1623311509790.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/29/3/c/a/6/1624943937577_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phan Ngọc Luân",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/DungLaiDeYeuNguoiMoi-PhanNgocLuan-7031281.mp3?st=fpJWcfLdfaHIvl_8za1Nmg&e=1626319088",
    //                 title: "Dừng Lại Để Yêu Người Mới",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dung-lai-de-yeu-nguoi-moi-phan-ngoc-luan.36pSHolvTDmo.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/07/06/7/a/3/0/1625566041719.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/25/e/4/6/f/1590405023576_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "VP Bá Vương, Tài Smile, TDK",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/CucDa-VPBaVuongTaiSmileTDK-7043876.mp3?st=kPOwtSoLh3tkmc2E74bJQA&e=1626319088",
    //                 title: "Cục Đá",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cuc-da-vp-ba-vuong-ft-tai-smile-ft-tdk.b3zoc7PadbtQ.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/17/f/b/d/5/1623899461943.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/09/21/e/f/4/b/1600677345904_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Linh Rin",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/ViDauAnhRoiXa-LinhRin-7034565.mp3?st=KY8lPQyvvHfaAp5EQbeIgA&e=1626319088",
    //                 title: "Vì Đâu Anh Rời Xa",
    //                 url: "https://www.nhaccuatui.com/bai-hat/vi-dau-anh-roi-xa-linh-rin.R10rNPiQbyKJ.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/21/f/8/4/8/1624257222968.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/10/17/4/2/a/d/1476698339496_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phúc Bồ, Tsix Rapper",
    //                 lyric: "",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/HayChoAnhBiet-PhucBoTsixRapper-7036119.mp3?st=epufq-x88Lb0QjafaPt72g&e=1626319088",
    //                 title: "Hãy Cho Anh Biết",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hay-cho-anh-biet-phuc-bo-ft-tsix-rapper.KUBcvAtil4QD.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/25/e/6/6/d/1624609387941.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/10/19/1/5/d/e/1476865750236_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Lý Tuấn Kiệt",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/YeuSaiNguoi-LyTuanKiet-7037403.mp3?st=uxxe4ZI7NOxxLxXjoLTm1Q&e=1626319088",
    //                 title: "Yêu Sai Người",
    //                 url: "https://www.nhaccuatui.com/bai-hat/yeu-sai-nguoi-ly-tuan-kiet.wWQL1QEnXvBA.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/11/2/b/b/7/1623398022603.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/10/20/a/0/d/f/1603170387400_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hồ Phong An",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/ChangCanDungSai-HoPhongAn-7031684.mp3?st=pzx6v514cyRf2qtCpYhfVQ&e=1626319088",
    //                 title: "Chẳng Cần Đúng Sai",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chang-can-dung-sai-ho-phong-an.x0McN7rgjNPs.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/05/15/c/f/3/0/1589532035884.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hoài Lâm",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/08/5/c/4/b/1615219889085.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui999/HoaNoKhongMau1-HoaiLam-6281704.mp3?st=n-ycYl4w9gNVmKZ8MZAogQ&e=1626319088",
    //                 title: "Hoa Nở Không Màu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hoa-no-khong-mau-hoai-lam.qbK16hjg5TdZ.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/16/1/a/6/3/1623837559949.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/04/19/0/c/1/d/1524133449013_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "NIT, Sing, Huyền Trang Lux",
    //                 lyric: "",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/DiQuaThanhXuan-NITSingHuyenTrangLux-7034469.mp3?st=JH6y-WXD8cOXw65hLMgV1A&e=1626319088",
    //                 title: "Đi Qua Thanh Xuân",
    //                 url: "https://www.nhaccuatui.com/bai-hat/di-qua-thanh-xuan-nit-ft-sing-ft-huyen-trang-lux.XHd8KZ5kOgK0.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/07/5/c/c/c/1623051024743.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/12/10/3/d/d/0/1607606332009_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hải Luân",
    //                 lyric: "",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/ChutDuAm-HaiLuan-7030453.mp3?st=zEjbrjTXoTHQwWtLWugTJw&e=1626319088",
    //                 title: "Chút Dư Âm",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chut-du-am-hai-luan.Awr9BfpcqgM4.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/15/0/f/0/b/1623735825259.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/07/13/6/6/2/4/1594610566834_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Gemini Band, Bằng Cường",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/NhuMotConMe-GeminiBandBangCuong-7032507.mp3?st=PjjubDMeQ4pxW9EX2jDeYA&e=1626319088",
    //                 title: "Như Một Cơn Mê",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nhu-mot-con-me-gemini-band-ft-bang-cuong.CzhNhi3Qo7LJ.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/28/8/4/3/c/1624854982856.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/10/20/a/0/d/f/1603169187914_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Kiun Gia Tuấn",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/07/08/6/e/d/5/1625716930218.lrc",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/ChacHoCoThuongEm-KiunGiaTuan-7038201.mp3?st=DxcciIZPlwOc0Koh3BIFVA&e=1626319088",
    //                 title: "Chắc Họ Có Thương Em",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chac-ho-co-thuong-em-kiun-gia-tuan.t0MMhX3bZPuJ.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/01/7/7/d/0/1614586501997.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/03/02/2/8/6/4/1614651512512_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Ricky Star, Lăng LD, AMee",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/08/5/c/4/b/1615219713146.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1010/TinhBanDieuKy-AMeeRickyStarLangLD-6927558.mp3?st=LOmzmd8GxndYK7WR0S8-Xw&e=1626319088",
    //                 title: "Tình Bạn Diệu Kỳ",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tinh-ban-dieu-ky-ricky-star-ft-lang-ld-ft-amee.SgXWolUyq8Dp.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/07/06/7/a/3/0/1625565258049.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/03/12/6/c/1/d/1583996623331_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "T00n, Luke Martins",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/MuonChillCungEm-T00nLukeMartins-7043869.mp3?st=U1EXy-CLGP5qtlwGiWLhMw&e=1626319088",
    //                 title: "Muốn Chill Cùng Em",
    //                 url: "https://www.nhaccuatui.com/bai-hat/muon-chill-cung-em-t00n-ft-luke-martins.wfiqi5CWXVTj.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/28/8/4/3/c/1624853479978.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/06/03/d/4/e/5/1591169993485_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hoàng Anh Duy",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/07/08/6/e/d/5/1625717261799.lrc",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/XaTamVoi-HoangAnhDuy-7038194.mp3?st=RBlLbkcsocZUCj_Kv6frYg&e=1626319088",
    //                 title: "Xa Tầm Với",
    //                 url: "https://www.nhaccuatui.com/bai-hat/xa-tam-voi-hoang-anh-duy.IiMT8iZeXVDo.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/03/19/2/6/e/8/1584612771231.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/01/22/9/6/7/5/1611280199069_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Văn Mai Hương, Hứa Kim Tuyền",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/03/24/6/6/6/3/1585022733533.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui996/UocMoCuaMe-VanMaiHuongHuaKimTuyen-6238645.mp3?st=oMX8MwD6pNGp-i6reQfvPQ&e=1626319088",
    //                 title: "Ước Mơ Của Mẹ",
    //                 url: "https://www.nhaccuatui.com/bai-hat/uoc-mo-cua-me-van-mai-huong-ft-hua-kim-tuyen.sPsWvcd6P32R.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/09/12/c/9/7/4/1568255951832.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590565041302_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Khắc Việt",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/01/17/5/3/4/3/1484643016250.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui154/YeuLaiTuDau-KhacViet_354qr.mp3?st=s7mkaFvvQz4jVLf1vjx5rA&e=1626319088",
    //                 title: "Yêu Lại Từ Đầu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/yeu-lai-tu-dau-khac-viet.oU0qaWPWljVh.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/04/27/f/2/1/d/1619515696259.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/09/22/5/3/5/d/1600744344048_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Đình Dũng, ACV",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/05/09/1/6/7/d/1620535411947.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1015/DungHenKiepSau1-DinhDungACV-7010665.mp3?st=VMMqi97tu10u5lMlh-yJpw&e=1626319088",
    //                 title: "Đừng Hẹn Kiếp Sau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dung-hen-kiep-sau-dinh-dung-ft-acv.EYUPzP2H8ChP.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/07/13/a/f/7/f/1594611971401.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/07/22/f/1/f/9/1595414808364_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Chillies, Suni Hạ Linh, Rhymastic",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/08/11/f/c/e/1/1597115627201.lrc",
    //                 music: "https://aredir.nixcdn.com/Warner_Audio33/CuChillThoi-ChilliesSuniHaLinhRhymastic-6330366.mp3?st=gl6OHLKaKvazuoEGhUiqnQ&e=1626319088",
    //                 title: "Cứ Chill Thôi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cu-chill-thoi-chillies-ft-suni-ha-linh-ft-rhymastic.I0ZXAn60MifT.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/07/03/7/5/b/e/1562137543919.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/05/12/7/d/c/b/1620802736418_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Sơn Tùng M-TP, Snoop Dogg",
    //                 lyric: "https://lrc-nct.nixcdn.com/2019/07/01/4/3/b/e/1561988730815.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui985/HayTraoChoAnh-SonTungMTPSnoopDogg-6010660.mp3?st=OJ3EIZ_O-ND7t3yY54z0Jw&e=1626319088",
    //                 title: "Hãy Trao Cho Anh",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hay-trao-cho-anh-son-tung-m-tp-ft-snoop-dogg.vtEybe9NxLw7.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/08/28/1/a/1/b/1503913422094.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/08/28/1/a/1/b/1503913422094_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tuấn Hưng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/12/17/3/e/8/0/1387222307806.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui109/DiVangCuocTinh-TuanHung_r5z4.mp3?st=YEBmjB0D_gSiLRwcd_ThRw&e=1626319088",
    //                 title: "Dĩ Vãng Cuộc Tình",
    //                 url: "https://www.nhaccuatui.com/bai-hat/di-vang-cuoc-tinh-tuan-hung.10MoSCJhUSdh.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/08/28/1/a/1/b/1503913422094.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/08/28/1/a/1/b/1503913422094_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tuấn Hưng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/11/03/8/e/e/8/1509683591754.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui239/TinhYeuLungLinh-TuanHung_bk.mp3?st=IaSv6Itdiu3BlMgxCMwoFQ&e=1626319088",
    //                 title: "Tình Yêu Lung Linh",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tinh-yeu-lung-linh-tuan-hung.dskfxTAMZacm.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/09/11/6/d/c/4/1568183645028.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/12/14/f/f/f/e/1544795511047_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Đông Nhi, Ông Cao Thắng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/10/08/d/0/7/0/1444269911742.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui924/TaLaCuaNhau-DongNhiOngCaoThang-4113753.mp3?st=LLes0YWF5S3d9alfh8F-sw&e=1626319088",
    //                 title: "Ta Là Của Nhau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ta-la-cua-nhau-dong-nhi-ft-ong-cao-thang.L0G5DzIXoFf3.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/03/31/4/6/f/c/1585621945561.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/03/15/4/7/7/8/1615802750962_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "X2X",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/04/01/a/e/1/1/1585708442390.lrc",
    //                 music: "https://aredir.nixcdn.com/Sony_Audio72/CoGiangTinh-X2X-6257264.mp3?st=4zOZUiXhP_9EkQH_8-I_aA&e=1626319088",
    //                 title: "Cố Giang Tình",
    //                 url: "https://www.nhaccuatui.com/bai-hat/co-giang-tinh-x2x.xyWHnC5qxlbd.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/04/13/9/7/d/5/1618248252948.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/04/12/1/1/7/2/1618223507852_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Jack - J97",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/04/13/6/7/1/3/1618283210428.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1014/Laylalay-JackG5R-7003742.mp3?st=gIcaz4RdvnQWbERxPaimyw&e=1626319088",
    //                 title: "Laylalay",
    //                 url: "https://www.nhaccuatui.com/bai-hat/laylalay-jack-j97.n8VupC0HXKgY.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/09/11/6/d/c/4/1568184053333.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/09/14/0/2/8/0/1600055795446_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Noo Phước Thịnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/07/21/b/f/c/e/1437461628517.lrc",
    //                 music: "https://aredir.nixcdn.com/Sony_Audio76/MaiMaiBenNhau-NooPhuocThinh-6456927.mp3?st=2EhrWZmb_EcwpBgJr6hyLA&e=1626319088",
    //                 title: "Mãi Mãi Bên Nhau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/mai-mai-ben-nhau-noo-phuoc-thinh.vu4LPajdrOQR.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/07/05/a/c/0/f/1499225305436.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/07/05/a/c/0/f/1499225305436_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Cao Thái Sơn",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/01/15/8/3/f/3/1421288738934.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio5/DieuNgotNgaoNhat-CaoThaiSon-2449094.mp3?st=jsETgNu-xjbIABugIf-2Wg&e=1626319088",
    //                 title: "Điều Ngọt Ngào Nhất",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dieu-ngot-ngao-nhat-cao-thai-son.5mSujbEjmniv.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/10/18/2/0/b/1/1571381118105.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/10/23/5/b/0/b/1571802458800_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hoàng Thùy Linh, Binz",
    //                 lyric: "https://lrc-nct.nixcdn.com/2019/10/21/5/4/4/2/1571630367160.lrc",
    //                 music: "https://aredir.nixcdn.com/Sony_Audio67/DiamondCutDiamond-HoangThuyLinhBINZ-6153594.mp3?st=rwOgtWYAOn6iPOYP_t_F3w&e=1626319088",
    //                 title: "Kẻ Cắp Gặp Bà Già",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ke-cap-gap-ba-gia-hoang-thuy-linh-ft-binz.TiYIAkGdU8ad.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/02/04/5/a/2/5/1612405167313.jpg",
    //                 bgImage: "",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Duongg, Nâu, W/n",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/05/19/f/d/5/c/1621391240674.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1011/31072-DuonggNauWn-6937818.mp3?st=8dxmXWVieeA6Fk8BmZ3jOA&e=1626319088",
    //                 title: "3 1 0 7 -2",
    //                 url: "https://www.nhaccuatui.com/bai-hat/3-1-0-7-2-duongg-ft-nau-ft-wn.owBN9o6aAZOe.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/11/20/d/f/9/a/1574242685613.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/11/20/d/f/9/a/1574242685613_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tăng Phúc, Trương Thảo Nhi",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1014/ChiLaKhongCungNhauLive-TangPhucTruongThaoNhi-6994969.mp3?st=jBIhsTtJpt_U1j43G3SY1A&e=1626319088",
    //                 title: "Chỉ Là Không Cùng Nhau (Live)",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chi-la-khong-cung-nhau-live-tang-phuc-ft-truong-thao-nhi.Ea8hu2FHnRf9.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/08/27/8/e/c/f/1598516178659.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/12/16/b/e/6/c/1576477671839_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "2T, ChangC",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/08/29/8/4/4/2/1598682547095.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1002/CuoiDi-2TChangC-6560962.mp3?st=VuSAR4COwkWeAip-74-z4Q&e=1626319088",
    //                 title: "Cưới Đi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cuoi-di-2t-ft-changc.wgpNJZxMdoMX.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/08/28/1/a/1/b/1503913422094.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/08/28/1/a/1/b/1503913422094_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tuấn Hưng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2019/04/22/a/6/2/3/1555913063523.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui960/DoiLong-TuanHung-5385147.mp3?st=D97wESGL49Oqh48W2Tw18Q&e=1626319088",
    //                 title: "Dối Lòng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/doi-long-tuan-hung.R6aEUeQBgIfV.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/06/12/5/b/c/b/1591950830200.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hoài Lâm",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/07/06/0/6/c/e/1594026785668.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1000/BuonLamChiEmOi1-HoaiLam-6297318.mp3?st=EjWouLYbCAJVgR9xj206TQ&e=1626319088",
    //                 title: "Buồn Làm Chi Em Ơi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/buon-lam-chi-em-oi-hoai-lam.utdMYQZ1ntVp.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/06/20/5/9/0/b/1560999333698.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/10/23/5/b/0/b/1571802458800_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Hoàng Thùy Linh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2019/06/24/b/f/7/2/1561363557566.lrc",
    //                 music: "https://aredir.nixcdn.com/Sony_Audio67/DeMiNoiChoMaNghe-HoangThuyLinh-6153588.mp3?st=9K9Dr-FpBj10Yfy28jf1xQ&e=1626319088",
    //                 title: "Để Mị Nói Cho Mà Nghe",
    //                 url: "https://www.nhaccuatui.com/bai-hat/de-mi-noi-cho-ma-nghe-hoang-thuy-linh.cxycw7eSvV7t.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/07/24/f/6/5/1/1595564868985.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/08/03/3/f/4/5/1596425146149_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Da LAB, Miu Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/08/03/1/b/b/4/1596444020821.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1001/GacLaiAuLo-DaLABMiuLe-6360815.mp3?st=bD5VMkK1ZPqeNnzCiOohxw&e=1626319088",
    //                 title: "Gác Lại Âu Lo",
    //                 url: "https://www.nhaccuatui.com/bai-hat/gac-lai-au-lo-da-lab-ft-miu-le.1uWWUf6ZAHC4.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/04/14/b/9/8/b/1618374024681.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/04/14/b/9/8/b/1618374024681_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phát Huy T4, KProx",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1015/DoanTuyetNangDiLofiVersion-PhatHuyT4KProx-7011827.mp3?st=50HvIdovhLcDhPY2EEjuNA&e=1626319088",
    //                 title: "Đoạn Tuyệt Nàng Đi (Lofi Version)",
    //                 url: "https://www.nhaccuatui.com/bai-hat/doan-tuyet-nang-di-lofi-version-phat-huy-t4-ft-kprox.BZqxPLSOerxC.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/07/03/7/5/b/e/1562146897414.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/08/13/7/d/5/0/1565688488776_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Phan Duy Anh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2019/06/13/a/1/0/5/1560383958108.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui983/TungYeu-PhanDuyAnh-5989256.mp3?st=l0ko4x9ChzvBKCljwAPYjw&e=1626319088",
    //                 title: "Từng Yêu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tung-yeu-phan-duy-anh.tnvcYCYt7lmv.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/11/01/2/e/b/0/1604211220367.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/07/30/6/0/5/f/1564481664878_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Quang Hùng MasterD",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/25/3/b/0/1/1616633924359.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1005/DeDenDeDi3-QuangHungMasterD-6791841.mp3?st=eA2gUhrdAVd4JlNXZZswrQ&e=1626319088",
    //                 title: "Dễ Đến Dễ Đi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/de-den-de-di-quang-hung-masterd.EOtJ5ddcidNb.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/09/22/5/3/5/d/1600744344048.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/09/22/5/3/5/d/1600744344048_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Đình Dũng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/10/21/d/2/7/6/1603249244672.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1000/TinhAnh-DinhDung-6286282.mp3?st=A1LIreYEfAn9AxpHQftK-g&e=1626319088",
    //                 title: "Tình Anh",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tinh-anh-dinh-dung.25AQhlbrrX8F.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/12/e/2/9/e/1615524008615.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/07/03/d/6/5/1/1530588757727_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Híu, Bâu",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/30/9/7/d/2/1617092838011.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1012/Matchanah-HiuBau-6964032.mp3?st=gRPQVWgl6JOOqXI2V3eEDA&e=1626319088",
    //                 title: "Matchanah",
    //                 url: "https://www.nhaccuatui.com/bai-hat/matchanah-hiu-ft-bau.ll6S5ChD4cbi.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/02/20/2/0/7/e/1582174982811.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/02/20/a/d/6/4/1582180833496_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tóc Tiên, Da LAB, Touliver",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/02/24/2/2/4/f/1582507447060.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui995/NgayTanThe-TocTienDaLABTouliver-6226260.mp3?st=GnHkxcQGS--3pbo9C5cHsg&e=1626319088",
    //                 title: "Ngày Tận Thế",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ngay-tan-the-toc-tien-ft-da-lab-ft-touliver.v4le5ZF0dej8.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/04/22/7/a/0/2/1619080811632.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/08/12/f/2/d/1/1597212025646_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Như Việt, ACV",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/04/28/c/4/8/e/1619619824859.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1015/NguoiLaTungThuong-NhuVietACV-7007396.mp3?st=VlYS260up3iyZikKmFu6PA&e=1626319088",
    //                 title: "Người Lạ Từng Thương",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nguoi-la-tung-thuong-nhu-viet-ft-acv.GLTlSZZ3DLiw.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/03/10/8/e/3/9/1583831167157.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/05/19/e/7/4/2/1495168123269_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tiên Tiên, JustaTee",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/04/24/9/6/4/2/1587715825528.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui996/CanGiHon-TienTienJustaTee-6236038.mp3?st=VeDvszU5peKXQXWgOgIYbA&e=1626319088",
    //                 title: "Cần Gì Hơn?",
    //                 url: "https://www.nhaccuatui.com/bai-hat/can-gi-hon-tien-tien-ft-justatee.zLxzzuaqmtyS.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/09/04/f/0/b/b/1599194035938.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/08/13/a/9/8/e/1597294555540_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tăng Duy Tân, Phong Max",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/09/06/b/1/a/0/1599365954570.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1003/NgayTho-TangDuyTanPhongMax-6590759.mp3?st=IFMCWODuzAtcy-NDAMQbpg&e=1626319088",
    //                 title: "Ngây Thơ",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ngay-tho-tang-duy-tan-ft-phong-max.aveYU3oi56R2.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/10/09/2/0/8/a/1539059336207.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/10/09/2/0/8/a/1539059336207_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Tân Trần",
    //                 lyric: "",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/BoEmVaoBalo-TanTran-7032056.mp3?st=HWuNw5KYE2zzA_mhSxEfIQ&e=1626319088",
    //                 title: "Bỏ Em Vào Balo",
    //                 url: "https://www.nhaccuatui.com/bai-hat/bo-em-vao-balo-tan-tran.HJeEJ2jENGBk.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2014/02/26/6/5/1/b/1393400883937.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2014/02/26/6/5/1/b/1393400883937_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Jombie, Tkan, Bean",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1014/CafeKhongDuong-JombieTkanBean-6996039.mp3?st=lKGyLJE8_zRw5IFgj_bUOw&e=1626319088",
    //                 title: "Cafe Không Đường",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cafe-khong-duong-jombie-ft-tkan-ft-bean.hPhCwnAGC2uE.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/23/6/f/3/9/1616492727175.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/12/14/2/5/3/b/1607910088022_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Anh Rồng, Tvk, Anh Hảo",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/03/25/3/b/0/1/1616634632510.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1013/AnhThuongEmMa-AnhRongTvkAnhHao-6981836.mp3?st=ogC_PEot9V1oDoswHmcpvw&e=1626319088",
    //                 title: "Anh Thương Em Mà",
    //                 url: "https://www.nhaccuatui.com/bai-hat/anh-thuong-em-ma-anh-rong-ft-tvk-ft-anh-hao.lFqnxUV3XuRw.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/05/28/a/5/3/8/1622187655260.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/11/15/2/7/c/d/1573834150811_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Thanh Hưng",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/AnhTheDay-ThanhHungIdol-7025973.mp3?st=fU1pi12hZN6HPUD8R0wDog&e=1626319088",
    //                 title: "Anh Thề Đấy",
    //                 url: "https://www.nhaccuatui.com/bai-hat/anh-the-day-thanh-hung.g57s5RtqK3Ub.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/27/d/2/9/1/1616857964884.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/11/21/c/4/8/a/1511239115657_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Uyên Linh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/04/09/8/a/8/2/1617939844077.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1013/GiuaDaiLoDongTay1-UyenLinh-6976855.mp3?st=l7DEZ5kQtbjSa5ry-buK6A&e=1626319088",
    //                 title: "Giữa Đại Lộ Đông Tây (Live At XHTDRLX)",
    //                 url: "https://www.nhaccuatui.com/bai-hat/giua-dai-lo-dong-tay-live-at-xhtdrlx-uyen-linh.2nUcx7xMw5iI.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/01/9/8/c/d/1622533502964.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/10/19/1/5/d/e/1476865750236_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //                 creator: "Lý Tuấn Kiệt",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/NoiDauCoTinhYeuThatSu-LyTuanKiet-7028701.mp3?st=jTzZdId37AoAHFUugFQjRA&e=1626319088",
    //                 title: "Nơi Đâu Có Tình Yêu Thật Sự",
    //                 url: "https://www.nhaccuatui.com/bai-hat/noi-dau-co-tinh-yeu-that-su-ly-tuan-kiet.Pu56bvqpOGbL.html",
    //             },
    //         ],
    //     },
    //     {
    //         name: "Trữ Tình",
    //         url: "https://nhaccuatui.com",
    //         songs: [
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/10/28/e/1/7/4/1603878026196.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/09/09/a/1/f/0/1410250218496.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1005/TromNhinNhau1-NhuQuynh-729574.mp3?st=ujZvAaS40BLZJ7rXMK2uPA&e=1626319090",
    //                 title: "Trộm Nhìn Nhau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/trom-nhin-nhau-nhu-quynh.1zSEZDWAyh.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717640989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717640989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Trường Vũ, Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/08/27/5/c/2/8/1440647461158.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui211/KhongGioRoi-TruongVu-NhuQuynh_3vg9m.mp3?st=wL2iXs9NBxOJKTOJMzipSQ&e=1626319090",
    //                 title: "Không Giờ Rồi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/khong-gio-roi-truong-vu-ft-nhu-quynh.0OoJcKy5U8ft.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh, Trường Vũ",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/11/07/c/a/f/f/1446910618848.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui173/DinhUoc-NhuQuynh-TruongVu_3aadk.mp3?st=n63LAVbvqiQd_u_z7YfArQ&e=1626319090",
    //                 title: "Đính Ước",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dinh-uoc-nhu-quynh-ft-truong-vu.8fCqeALqilNm.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/10/30/c/6/8/9/1414641934288.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui166/XinThoiGianQuaMau-QuangLe_388zz.mp3?st=XTP9zZVLouwR-1CQ57_oOQ&e=1626319090",
    //                 title: "Xin Thời Gian Qua Mau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/xin-thoi-gian-qua-mau-quang-le.y5yYnMaZAKYv.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/01/11/8/a/6/c/1515660718081.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/01/11/8/a/6/c/1515660718081_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Phi Nhung",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/bd2013/Ao-Moi-Ca-Mau-Phi-Nhung-5106.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui203/AoMoiCaMau-PhiNhung_3nkxy.mp3?st=XHnOK-Rvn5q6u2d59-XYag&e=1626319090",
    //                 title: "Áo Mới Cà Mau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ao-moi-ca-mau-phi-nhung.twvbt5PXM91T.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/01/11/8/a/6/c/1515660718081.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/01/11/8/a/6/c/1515660718081_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Phi Nhung",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/03/21/8/5/e/6/1426940740850.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui934/BongDienDien-PhiNhung-2447015.mp3?st=TK3k6XXcCXtuuiKwqLXV3Q&e=1626319090",
    //                 title: "Bông Điên Điển",
    //                 url: "https://www.nhaccuatui.com/bai-hat/bong-dien-dien-phi-nhung.v5oYwH4d5pra.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453716412362.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453716412362_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Mai Thiên Vân, Trường Vũ",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/11/14/0/c/4/f/1479098789063.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui931/HaiDuaGianNhau-MaiThienVanTruongVu-3146069.mp3?st=iPtTtQGbexiLmCpqJcm-tA&e=1626319090",
    //                 title: "Hai Đứa Giận Nhau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hai-dua-gian-nhau-mai-thien-van-ft-truong-vu.bSpI1xCYsdMU.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh, Hoàng Oanh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/03/01/0/c/f/a/1488338913819.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui937/MuaDemNgoaiO-NhuQuynhHoangOanh-4772883.mp3?st=x561lu6jDUuMRcKb-vQzEQ&e=1626319090",
    //                 title: "Mưa Đêm Ngoại Ô",
    //                 url: "https://www.nhaccuatui.com/bai-hat/mua-dem-ngoai-o-nhu-quynh-ft-hoang-oanh.XLQcPMm2FDro.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/09/09/a/1/f/0/1410279785296.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui932/TraLaiThoiGian-NhuQuynh-3148429.mp3?st=PRxLe46cM1ZtujOyOav2HA&e=1626319090",
    //                 title: "Trả Lại Thời Gian",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tra-lai-thoi-gian-nhu-quynh.4IojXcjbOZEE.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/07/25/0/e/3/2/1564030757569.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê, Lam Anh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/10/30/c/6/8/9/1414672706125.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui986/ChieuSanGa-QuangLeLamAnh-3601177.mp3?st=BSlVKz3A3b9c9masOpL8vg&e=1626319090",
    //                 title: "Chiều Sân Ga",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chieu-san-ga-quang-le-ft-lam-anh.E5xny7Ld5fBi.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê, Mai Thiên Vân",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/12/16/3/5/9/5/1481856080357.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui962/ChuyenTinhNguoiDanAo-QuangLeMaiThienVan-4184289.mp3?st=3LqTyYMvYcrQ19s0LEDLjw&e=1626319090",
    //                 title: "Chuyện Tình Người Đan Áo",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chuyen-tinh-nguoi-dan-ao-quang-le-ft-mai-thien-van.Z9RUaIMyMyy7.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/03/01/1/c/9/2/1425227379986.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui206/HoaNoVeDem-NhuQuynh_3rs3z.mp3?st=HrCfl6GLt7R4fx3P4S_c9Q&e=1626319090",
    //                 title: "Hoa Nở Về Đêm",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hoa-no-ve-dem-nhu-quynh.FemOipTckI.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717930700.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717930700_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Chế Linh, Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/02/22/f/e/8/5/1487713660750.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui937/TinhDoi-CheLinhNhuQuynh-4772885.mp3?st=orGAI7izlfgsvMHdCvs01A&e=1626319090",
    //                 title: "Tình Đời",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tinh-doi-che-linh-ft-nhu-quynh.QvpJRVlItNeY.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/01/11/8/a/6/c/1515660718081.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/01/11/8/a/6/c/1515660718081_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Phi Nhung",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/bd2013/Em-Ve-Keo-Troi-Mua-Phi-Nhung-11461.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui934/EmVeKeoTroiMua-PhiNhung-2267264.mp3?st=YbDsosqRGM3kwQfpLrnDHA&e=1626319090",
    //                 title: "Em Về Kẻo Trời Mưa",
    //                 url: "https://www.nhaccuatui.com/bai-hat/em-ve-keo-troi-mua-phi-nhung.dIUHR1TAxrxW.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/03/01/1/c/9/2/1425191084264.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio5/DapVoCayDan-QuangLe-2557858.mp3?st=iQVTuEIkVq1RvoDH1wetXw&e=1626319090",
    //                 title: "Đập Vỡ Cây Đàn",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dap-vo-cay-dan-quang-le.TroiuRI0vopC.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2017/11/30/f/e/3/c/1512014149531.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717640989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Trường Vũ",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/11/30/6/2/6/b/1512015391412.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui954/ThanhPhoBuon-TruongVu-2894516.mp3?st=oHnKNcya_QTBiJhsWyKZcw&e=1626319090",
    //                 title: "Thành Phố Buồn",
    //                 url: "https://www.nhaccuatui.com/bai-hat/thanh-pho-buon-truong-vu.T0xxwT23J1Xh.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453716001206.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453716001206_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Huỳnh Nguyễn Công Bằng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2019/04/18/6/3/1/a/1555535267702.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui878/CatBuiCuocDoi-HuynhNguyenCongBang-3658039.mp3?st=VpNvY9UUgvmWZL45KAhFPA&e=1626319090",
    //                 title: "Cát Bụi Cuộc Đời",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cat-bui-cuoc-doi-huynh-nguyen-cong-bang.HwMCofYqfzz9.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/07/29/3/0/0/9/1564389948470.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê, Mai Thiên Vân",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/12/11/e/0/0/a/1418273179913.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui986/CanNhaMauTim-QuangLeMaiThienVan-512771.mp3?st=BeHnlKJ5aDJy7FV_goM_3g&e=1626319090",
    //                 title: "Căn Nhà Màu Tím",
    //                 url: "https://www.nhaccuatui.com/bai-hat/can-nha-mau-tim-quang-le-ft-mai-thien-van.44FoDLoyHy.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/11/10/c/1/7/f/1510306916422.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui828/HaiChuyenTauDem-QuangLe-2430403.mp3?st=5cfGaG-GJpQReHYT6j6h8Q&e=1626319090",
    //                 title: "Hai Chuyến Tàu Đêm",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hai-chuyen-tau-dem-quang-le.vMJ4S7KaAzRU.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/01/28/7/7/0/e/1548659364646.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/01/29/7/6/b/4/1517209100178.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui932/CauChuyenDauNam-NhuQuynh-3145064.mp3?st=QXrKdvrFHy3nVPq_GqF0-g&e=1626319090",
    //                 title: "Câu Chuyện Đầu Năm",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cau-chuyen-dau-nam-nhu-quynh.0h9drXBWAxSm.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/09/01/d/7/1/c/1441092836192.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui936/ThoiDoi-DanNguyen-427729.mp3?st=xTvuY72n6xhUJQtxrpbexA&e=1626319090",
    //                 title: "Thói Đời",
    //                 url: "https://www.nhaccuatui.com/bai-hat/thoi-doi-dan-nguyen.Zh5xT4dfY-.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Cẩm Ly, Quốc Đại",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/03/19/a/a/1/0/1426769073532.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui239/VeMienTay-CamLy-QuocDai_gy.mp3?st=aQwzR0PqM54dlnWniL1yeg&e=1626319090",
    //                 title: "Về Miền Tây",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ve-mien-tay-cam-ly-ft-quoc-dai.djn7L0FBksb4.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Cẩm Ly",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/10/07/2/f/9/a/1475824570658.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui240/KhongBaoGioQuenAnh-CamLy_qd.mp3?st=eoxarwvBeA4RmVS1HY0VEg&e=1626319090",
    //                 title: "Không Bao Giờ Quên Anh",
    //                 url: "https://www.nhaccuatui.com/bai-hat/khong-bao-gio-quen-anh-cam-ly.dYxJsN13CaEX.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/03/12/c/e/0/9/1520844402716.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/03/12/c/e/0/9/1520844402716_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lưu Ánh Loan, Đoàn Minh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/01/04/9/7/5/4/1483541827723.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui934/LaiNhoNguoiYeu-LuuAnhLoanDoanMinh-4728910.mp3?st=IU_SbfOKSIhhEgZGNdBpCA&e=1626319090",
    //                 title: "Lại Nhớ Người Yêu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/lai-nho-nguoi-yeu-luu-anh-loan-ft-doan-minh.Rx94fVfCCcf0.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/28/b/2/0/9/1624874365121.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/28/b/2/0/9/1624874365121_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Trường",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/11/03/8/e/e/8/1509680487902.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui934/KiepVeSau-DanTruong-2445024.mp3?st=oeuiqTzONwUcqduA7FXahg&e=1626319090",
    //                 title: "Kiếp Ve Sầu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/kiep-ve-sau-dan-truong.PD8udrFtfCB1.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/06/19/f/d/c/8/1466321354837.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui151/NguoiYeuCoDon-DanNguyen_348hf.mp3?st=QyXlh1Wlcmi5817NDoduDA&e=1626319090",
    //                 title: "Người Yêu Cô Đơn",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nguoi-yeu-co-don-dan-nguyen.QkWXDMHDpe.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453715646175.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453715646175_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Giáng Tiên, Dương Ngọc Thái",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/07/23/f/a/a/5/1437662728295.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui219/DuongTinhDoiNga-GiangTien-DuongNgo_3zcyv.mp3?st=ulFXBETULdtThbxdglnMww&e=1626319090",
    //                 title: "Đường Tình Đôi Ngã",
    //                 url: "https://www.nhaccuatui.com/bai-hat/duong-tinh-doi-nga-giang-tien-ft-duong-ngoc-thai.Hq8RzitChBG6.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/10/30/4/0/0/1/1572405540270.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/10/30/4/0/0/1/1572405540270_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đàm Vĩnh Hưng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/Vietnamese/Xin-Loi-Tinh-Yeu-Dam-Vinh-Hung.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui842/XinLoiTinhyeu-DamVinhHung-1112424.mp3?st=JwPqyvhisn2qtjWN8ZbK3w&e=1626319090",
    //                 title: "Xin Lỗi Tình Yêu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/xin-loi-tinh-yeu-dam-vinh-hung.qMFKz4uCBYCP.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lệ Quyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/05/17/6/d/b/5/1431828846830.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui889/HoaNoVeDem-LeQuyen-3816892.mp3?st=ZtagNbTOnVYONJP2A6BrEg&e=1626319090",
    //                 title: "Hoa Nở Về Đêm",
    //                 url: "https://www.nhaccuatui.com/bai-hat/hoa-no-ve-dem-le-quyen.44daCLrxlnTd.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2017/12/21/d/c/5/f/1513829929564.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên, Phi Nhung",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/04/19/7/6/c/2/1524115490240.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui956/BacTrangLuaHong-DanNguyenPhiNhung-5325039.mp3?st=38svPOOyJoeNIOZnUgDsRA&e=1626319090",
    //                 title: "Bạc Trắng Lửa Hồng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/bac-trang-lua-hong-dan-nguyen-ft-phi-nhung.yAd5mb4STliY.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/07/25/0/e/3/2/1564016132793.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lệ Quyên, Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/11/20/6/1/b/b/1511164801551.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio5/SauTimThiepHong-LeQuyenQuangLe-2448476.mp3?st=8EyFPhVos6Ow2KIOUBfxRg&e=1626319090",
    //                 title: "Sầu Tím Thiệp Hồng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/sau-tim-thiep-hong-le-quyen-ft-quang-le.367fYBSxm8Cr.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/11/09/8/f/5/e/1447079987380.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui932/MuaRung-NhuQuynh-3147061.mp3?st=1ayF111jNIiWRZtsdA6YqQ&e=1626319090",
    //                 title: "Mưa Rừng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/mua-rung-nhu-quynh.0XQCuvjqNFmK.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/03/12/c/e/0/9/1520844402716.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/03/12/c/e/0/9/1520844402716_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lưu Ánh Loan, Mạnh Đồng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/12/18/e/1/c/0/1387333721288.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui934/TinhNgheoCoNhau-LuuAnhLoanManhDong-4728906.mp3?st=SAzIENq7Em4OEJIa2WQa0w&e=1626319090",
    //                 title: "Tình Nghèo Có Nhau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tinh-ngheo-co-nhau-luu-anh-loan-ft-manh-dong.L5aheYXeoyfp.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh, Trường Vũ",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/01/01/5/5/6/2/1483224348838.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui929/DongCanhNgo-NhuQuynhTruongVu-4632855.mp3?st=Al1rHQobdLzrvfutucLWeA&e=1626319090",
    //                 title: "Đồng Cảnh Ngộ",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dong-canh-ngo-nhu-quynh-ft-truong-vu.4D2uQYWczCFb.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/01/20/b/e/0/9/1421758420539.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio5/CoHangXom-QuangLe-2555547.mp3?st=p3C7zw6N2urmS5p1Un5Hng&e=1626319090",
    //                 title: "Cô Hàng Xóm",
    //                 url: "https://www.nhaccuatui.com/bai-hat/co-hang-xom-quang-le.zhPm6EAh9jgN.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Cẩm Ly",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/Vietnamese/Noi-buon-hoa-phuong-cam-ly.lrc",
    //                 music: "https://aredir.nixcdn.com/NCTOfficial1/NoiBuonHoaPhuong-CamLy_7gd.mp3?st=wSUkJX4HOM5A77Im4QGkVg&e=1626319090",
    //                 title: "Nỗi Buồn Hoa Phượng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/noi-buon-hoa-phuong-cam-ly.dbLkJYO5MPoJ.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Cẩm Ly, Quốc Đại",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/12/29/0/a/5/b/1388316564566.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui239/ChoVuaLongEm-CamLy-QuocDai_h6.mp3?st=BJuR-8Bo75jyU7JomD_8BQ&e=1626319090",
    //                 title: "Cho Vừa Lòng Em",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cho-vua-long-em-cam-ly-ft-quoc-dai.dUoReuk0OH5r.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/10/15/f/c/7/d/1539604269518.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui883/TuyCa-DanNguyen-3736104.mp3?st=YXWU6138ff3JKAdi8DU09Q&e=1626319090",
    //                 title: "Túy Ca",
    //                 url: "https://www.nhaccuatui.com/bai-hat/tuy-ca-dan-nguyen.Xt0EEaizen3L.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/bd2013/Xin-Goi-Nhau-La-Co-Nhan-Quang-Le-40391.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui153/XinGoiNhauLaCoNhan-QuangLe_34wvz.mp3?st=SS05gEDbbWX6_M9RM4niAg&e=1626319090",
    //                 title: "Xin Gọi Nhau Là Cố Nhân",
    //                 url: "https://www.nhaccuatui.com/bai-hat/xin-goi-nhau-la-co-nhan-quang-le.0EXCrICHpbF7.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/01/28/7/7/0/e/1548659402758.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/07/28/2/f/b/9/1438087735786.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui218/DuyenPhan-NhuQuynh_3z7ay.mp3?st=PvoGgHDNKPwOQe3Fweu0Xg&e=1626319090",
    //                 title: "Duyên Phận",
    //                 url: "https://www.nhaccuatui.com/bai-hat/duyen-phan-nhu-quynh.2iu0Q9dbU4pM.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/04/13/3/0/e/7/1460555247002.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui831/ChuyenTinhKhongDiVang-QuangLe-2511591.mp3?st=DvPLojGCxJlGt8y9lAa7MQ&e=1626319090",
    //                 title: "Chuyện Tình Không Dĩ Vãng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chuyen-tinh-khong-di-vang-quang-le.adxeEyWOg09n.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2018/01/04/4/2/6/4/1515035254636.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/03/06/1/9/e/2/1551842355087_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Khánh Bình, Dương Hồng Loan",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/01/07/5/4/d/8/1515333638180.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui957/ConDuongMangTenEm-KhanhBinhDuongHongLoan-5333029.mp3?st=YtmLxkLsWzYRwLyIV13TTg&e=1626319090",
    //                 title: "Con Đường Mang Tên Em",
    //                 url: "https://www.nhaccuatui.com/bai-hat/con-duong-mang-ten-em-khanh-binh-ft-duong-hong-loan.ZDUh6eQbIT5b.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh, Phi Nhung",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/04/12/2/1/c/9/1460441507953.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui207/GiacMoCanhCo-NhuQuynh-PhiNhung_3sxmr.mp3?st=z0fQT_mxyIX61fhf-er7aQ&e=1626319090",
    //                 title: "Giấc Mơ Cánh Cò",
    //                 url: "https://www.nhaccuatui.com/bai-hat/giac-mo-canh-co-nhu-quynh-ft-phi-nhung.pMCDW7JfdGlW.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/12/31/0/9/3/8/1483172606807.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui188/DemLangThang-DanNguyen_3ef7t.mp3?st=FZBjzRr4Si-fFuFWPuaT6g&e=1626319090",
    //                 title: "Đêm Lang Thang",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dem-lang-thang-dan-nguyen.CixLrjBYV1.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lệ Quyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/Vietnamese/Ngon-Truc-Dao-Le-Quyen.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio5/NgonTrucDao-LeQuyen-2449151.mp3?st=jPfQWO6xIXTzbr34IE66HA&e=1626319090",
    //                 title: "Ngọn Trúc Đào",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ngon-truc-dao-le-quyen.OfXirEqo4SQ2.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Cẩm Ly",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/01/26/f/c/5/7/1422279216267.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui191/VongCoBuon-CamLy_3fcpf.mp3?st=PQreIyorQcOO0WJJYNG_Uw&e=1626319090",
    //                 title: "Vọng Cổ Buồn",
    //                 url: "https://www.nhaccuatui.com/bai-hat/vong-co-buon-cam-ly.SnRrjCxs7hBA.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/10/30/4/0/0/1/1572405540270.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/10/30/4/0/0/1/1572405540270_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đàm Vĩnh Hưng",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/04/14/0/d/3/f/1460624517163.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui076/Demnayaiduaemve-DamVinhHung_e63f.mp3?st=1NOtkBUw7eqG2mWyrp1Q3A&e=1626319090",
    //                 title: "Ai Đưa Em Về",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ai-dua-em-ve-dam-vinh-hung.Mf2javYXegOb.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lệ Quyên, Tuấn Ngọc",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/06/02/d/a/f/9/1464883263213.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui921/BaiKhongTenCuoiCung-LeQuyenTuanNgoc-4455820.mp3?st=z9uBMud_ntIuQi896jeZXw&e=1626319090",
    //                 title: "Bài Không Tên Cuối Cùng (Liveshow Tình Khúc Vũ Thành An)",
    //                 url: "https://www.nhaccuatui.com/bai-hat/bai-khong-ten-cuoi-cung-liveshow-tinh-khuc-vu-thanh-an-le-quyen-ft-tuan-ngoc.WdZUfAqS9G3B.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717856172.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717856172_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Thanh Tuyền, Mai Quốc Huy",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/08/07/8/6/6/a/1438930535078.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui223/DungNoiXaNhau-ThanhTuyen-MaiQuocH_43jxm.mp3?st=ZV1roeeg8YFCvXvjMqHXog&e=1626319090",
    //                 title: "Đừng Nói Xa Nhau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dung-noi-xa-nhau-thanh-tuyen-ft-mai-quoc-huy.S4HEPTgAbyRO.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2018/02/09/a/4/8/8/1518146738089.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/02/07/c/6/d/c/1486442009467.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui936/MuoiNamTinhCu-DanNguyen-4761256.mp3?st=jOAxj4QGer-sXKnPDtAyqw&e=1626319090",
    //                 title: "Mười Năm Tình Cũ",
    //                 url: "https://www.nhaccuatui.com/bai-hat/muoi-nam-tinh-cu-dan-nguyen.1p9Ae1Ib8Y0g.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Hoài Lâm",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/07/01/b/0/f/2/1404179302754.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui935/VeDauMaiTocNguoiThuong-HoaiLam-4032655.mp3?st=6UG2fruBTKHloJK2M0wcZQ&e=1626319090",
    //                 title: "Về Đâu Mái Tóc Người Thương",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ve-dau-mai-toc-nguoi-thuong-hoai-lam.sarns161pWv6.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/07/25/0/e/3/2/1564029823917.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê, Lam Anh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/10/30/c/6/8/9/1414641905120.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui986/NguoiYeuCoDon-QuangLeLamAnh-3601140.mp3?st=n0aRQAFf5N8KnuY_7hn9Hw&e=1626319090",
    //                 title: "Người Yêu Cô Đơn",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nguoi-yeu-co-don-quang-le-ft-lam-anh.jRPa5LzT8QO4.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lệ Quyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/06/16/e/4/7/c/1466044989827.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio5/BaiKhongTenSo1-LeQuyen-3652832.mp3?st=8AbzxA2HxOLwpo9rxxFjPQ&e=1626319090",
    //                 title: "Bài Không Tên Số 1",
    //                 url: "https://www.nhaccuatui.com/bai-hat/bai-khong-ten-so-1-le-quyen.WoNR8qE41X4j.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/03/13/7/c/d/a/1552459845615.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/12/21/3/3/8/8/1545372943792_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lê Sang, Kim Thoa",
    //                 lyric: "https://lrc-nct.nixcdn.com/2019/06/12/7/2/c/5/1560287479543.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui978/DuongTimBangLang-LeSangKimThoa-5908402.mp3?st=N17G4hTXYgRzwvDvSyU5Wg&e=1626319090",
    //                 title: "Đường Tím Bằng Lăng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/duong-tim-bang-lang-le-sang-ft-kim-thoa.6XzEcqT9uJf4.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/01/20/b/e/0/9/1421688165292.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio5/ChuyenHenHo-QuangLe-2555550.mp3?st=zecnf4anHkS78LMBKFGjRg&e=1626319090",
    //                 title: "Chuyện Hẹn Hò",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chuyen-hen-ho-quang-le.gKopvlSzd3Fw.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/09/10/f/7/3/1/1410307179352.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui208/ChoNguoi-NhuQuynh_3t54c.mp3?st=qeRRgpIGOVrMdxTEZ-JCMQ&e=1626319091",
    //                 title: "Chờ Người",
    //                 url: "https://www.nhaccuatui.com/bai-hat/cho-nguoi-nhu-quynh.BE6FYMaFUd.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/03/11/b/c/a/e/1457671840830.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui202/XinEmDungKhocVuQuy-QuangLe_3mt3u.mp3?st=72n_epOq3aQvrzLqQPyE-Q&e=1626319091",
    //                 title: "Xin Em Đừng Khóc Vu Quy",
    //                 url: "https://www.nhaccuatui.com/bai-hat/xin-em-dung-khoc-vu-quy-quang-le.ZTqlBQvE5DJo.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê, Mai Thiên Vân",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/03/19/a/a/1/0/1426783554803.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui152/PhaiLongConGaiBenTre-QuangLe-Mai_34n2h.mp3?st=kjHRh2-w1k3CvznvR_ffbQ&e=1626319091",
    //                 title: "Phải Lòng Con Gái Bến Tre",
    //                 url: "https://www.nhaccuatui.com/bai-hat/phai-long-con-gai-ben-tre-quang-le-ft-mai-thien-van.cbbcvq1n55Zk.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717640989.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717640989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Trường Vũ",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/08/16/5/a/9/e/1439730038304.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui828/LanVaDiep-TruongVu-2440779.mp3?st=fTrnFrq8Oh5mBzcgbElRNA&e=1626319091",
    //                 title: "Lan Và Điệp",
    //                 url: "https://www.nhaccuatui.com/bai-hat/lan-va-diep-truong-vu.Fme5wsMCvWiR.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/28/b/2/0/9/1624874365121.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/28/b/2/0/9/1624874365121_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Trường",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/07/10/7/e/d/9/1436531857033.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui194/NoiToi-DanTruong_3gr7q.mp3?st=MDNiTeQ4op6Wfjg1AdzS6A&e=1626319091",
    //                 title: "Nội Tôi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/noi-toi-dan-truong.EWyum94Qxc4s.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/Vietnamese/Doi-mat-nguoi-xua-Dan-Nguyen.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui210/DoiMatNguoiXua-DanNguyen_3ushn.mp3?st=pq30mhiOr4kKcRvd7eXS_w&e=1626319091",
    //                 title: "Đôi Mắt Người Xưa",
    //                 url: "https://www.nhaccuatui.com/bai-hat/doi-mat-nguoi-xua-dan-nguyen.3glw8uVQzE.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/10/16/f/8/f/a/1571212609712.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/05/25/3/8/7/6/1464137015526.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1005/VungLaMeBay1-NhuQuynh-4453354.mp3?st=ssbIO2oCdzgxKIqg16TkuA&e=1626319091",
    //                 title: "Vùng Lá Me Bay",
    //                 url: "https://www.nhaccuatui.com/bai-hat/vung-la-me-bay-nhu-quynh.1vOXeobFy4lf.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/09/05/9/d/3/7/1409926081039.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio1/DoiMatNguoiXua-QuangLe-2555551.mp3?st=8B30GVqb5HSfbdeAryJ6sg&e=1626319091",
    //                 title: "Đôi Mắt Người Xưa",
    //                 url: "https://www.nhaccuatui.com/bai-hat/doi-mat-nguoi-xua-quang-le.DaGFbDYExGm1.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/06/24/3/a/0/6/1498273863103.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui829/LinhHonTuongDa-DanNguyen-2451486.mp3?st=jhbnjqK3TkaEpQnO2-_ziA&e=1626319091",
    //                 title: "Linh Hồn Tượng Đá",
    //                 url: "https://www.nhaccuatui.com/bai-hat/linh-hon-tuong-da-dan-nguyen.Ecv3iWyojGlC.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2018/02/09/a/4/8/8/1518146750375.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên, Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/02/07/c/6/d/c/1486449810801.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui936/DuyenPhan-DanNguyenNhuQuynh-4761260.mp3?st=LxLqn9IwRopZDpsHYaBYLA&e=1626319091",
    //                 title: "Duyên Phận",
    //                 url: "https://www.nhaccuatui.com/bai-hat/duyen-phan-dan-nguyen-ft-nhu-quynh.5pzjTHSLefNV.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2013/Vietnamese/Ve-dau-mai-toc-nguoi-thuong-dan-nguyen.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui217/VeDauMaiTocNguoiThuong-DanNguyen_3yf28.mp3?st=hYPu-46Mecp1JA3pEv6nuw&e=1626319091",
    //                 title: "Về Đâu Mái Tóc Người Thương",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ve-dau-mai-toc-nguoi-thuong-dan-nguyen.3Nkj6XzhKr.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/12/31/0/9/3/8/1483143771250.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui210/BuonTrongKyNiem-DanNguyen_3ushm.mp3?st=I3V3l9vrWR-z2ID5p4oH7A&e=1626319091",
    //                 title: "Buồn Trong Kỷ Niệm",
    //                 url: "https://www.nhaccuatui.com/bai-hat/buon-trong-ky-niem-dan-nguyen.WeKmWDkkwL.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/07/29/3/0/0/9/1564388299217.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê, Lệ Quyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/08/12/0/e/3/3/1407831856495.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui211/KhongGioRoi-QuangLe-LeQuyen_3vncw.mp3?st=9Hf-sVc3_8B5Gmpg8kwv7w&e=1626319091",
    //                 title: "Không Giờ Rồi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/khong-gio-roi-quang-le-ft-le-quyen.OubOaQJizNud.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/17/7/2/a/2/1568707006619_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lệ Quyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/10/12/8/5/2/f/1413121884505.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui239/NoiNhoMuaDong-LeQuyen_he.mp3?st=2UYmwAAmHt5fb1Wysukjfg&e=1626319091",
    //                 title: "Nỗi Nhớ Mùa Đông",
    //                 url: "https://www.nhaccuatui.com/bai-hat/noi-nho-mua-dong-le-quyen.dZ5xaYpf60lv.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/28/b/2/0/9/1624874365121.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/28/b/2/0/9/1624874365121_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Trường, Lương Bích Hữu",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/01/02/7/9/c/3/1420162749547.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui926/HuongTocMaNon-DanTruongLuongBichHuu-2872880.mp3?st=9vvQn7pzFK6HY1oQwewR8Q&e=1626319091",
    //                 title: "Hương Tóc Mạ Non",
    //                 url: "https://www.nhaccuatui.com/bai-hat/huong-toc-ma-non-dan-truong-ft-luong-bich-huu.7bsGINMBH9eb.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/10/12/0/7/8/b/1539338478494.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui942/LoiDangChoCuocTinh-DanNguyen-419948.mp3?st=kNY39Wd0Nghn_ncUpp0VwA&e=1626319091",
    //                 title: "Lời Đắng Cho Cuộc Tình",
    //                 url: "https://www.nhaccuatui.com/bai-hat/loi-dang-cho-cuoc-tinh-dan-nguyen.-XF_LMxiG2.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/06/22/8/4/c/5/1466564788927.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui936/CanNhaMauTim-DanNguyen-694874.mp3?st=93JplxGFLccmGY6bRh2jZg&e=1626319091",
    //                 title: "Căn Nhà Màu Tím",
    //                 url: "https://www.nhaccuatui.com/bai-hat/can-nha-mau-tim-dan-nguyen.78Luu6Z2wI.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2017/11/28/a/e/5/a/1511857147290.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/27/9/c/a/5/1490603602086_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Cẩm Ly, Quang Linh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/01/14/4/9/9/5/1421204495279.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui954/ThuongNhauLyToHong-CamLyQuangLinh-2555050.mp3?st=3sqaPOaMOpeyHul_Mx7Q0Q&e=1626319091",
    //                 title: "Thương Nhau Lý Tơ Hồng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/thuong-nhau-ly-to-hong-cam-ly-ft-quang-linh.w9zLOBI2n02b.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/22/7/e/b/2/1490173254205.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/22/7/e/b/2/1490173254205_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Hương Lan",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/05/09/7/a/9/1/1399603441137.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui932/QueEmMuaNuocLu-HuongLan-2591663.mp3?st=s4_Eg3sPJchGrAGbcqA_Og&e=1626319091",
    //                 title: "Quê Em Mùa Nước Lũ",
    //                 url: "https://www.nhaccuatui.com/bai-hat/que-em-mua-nuoc-lu-huong-lan.qAq87zsnuppq.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717125957.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717125957_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Giao Linh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/12/08/3/8/d/d/1544240465311.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui935/NhatKyDoiToi-GiaoLinh-2595690.mp3?st=Np1jQg9NUUSPYqbW2GrDIw&e=1626319091",
    //                 title: "Nhật Ký Đời Tôi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nhat-ky-doi-toi-giao-linh.k6TnjMU2HFmS.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2018/02/09/a/4/8/8/1518146723169.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/10/10/e/2/6/f/1507608663857.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui956/LaiNhoNguoiYeu-DanNguyen-4632876.mp3?st=0dqY0Nb49rAp05WFtISV4g&e=1626319091",
    //                 title: "Lại Nhớ Người Yêu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/lai-nho-nguoi-yeu-dan-nguyen.xpY0DPoR9Clm.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717828993.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717828993_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Bằng Kiều, Lam Anh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/02/21/f/1/4/b/1487663403533.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui937/DinhMenh-BangKieuLamAnh-4772905.mp3?st=esK4YsCywHY836QvvKAw_w&e=1626319091",
    //                 title: "Định Mệnh",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dinh-menh-bang-kieu-ft-lam-anh.6ofWE8rVAfnX.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/10/05/b/a/0/4/1538735564719.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui829/DapMoCuocTinh-DanNguyen-2460868.mp3?st=xWkWJFUOpoVJ6OH9WB1kIw&e=1626319091",
    //                 title: "Đắp Mộ Cuộc Tình",
    //                 url: "https://www.nhaccuatui.com/bai-hat/dap-mo-cuoc-tinh-dan-nguyen.wbktC1WAtkCq.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê, Mai Thiên Vân",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/04/12/2/1/c/9/1460443056107.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio1/NhaAnhNhaEm-QuangLeMaiThienVan-2542039.mp3?st=iNmUGQRflOHFtHTyYDwDcQ&e=1626319091",
    //                 title: "Nhà Anh Nhà Em",
    //                 url: "https://www.nhaccuatui.com/bai-hat/nha-anh-nha-em-quang-le-ft-mai-thien-van.GZfDGN2Tbqp1.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2018/01/24/b/6/1/b/1516764559678.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Hoài Lâm",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/01/24/f/9/3/e/1516759659842.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui959/AoLuaHaDong-HoaiLam-5361840.mp3?st=TxJ5zAgzlO8Mc09_Hzn6HA&e=1626319091",
    //                 title: "Áo Lụa Hà Đông",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ao-lua-ha-dong-hoai-lam.pWbVPUL6L1od.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/02/06/3/4/7/f/1486358917132_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quang Lê",
    //                 lyric: "https://lrc-nct.nixcdn.com/2020/08/07/9/7/6/2/1596801616332.lrc",
    //                 music: "https://aredir.nixcdn.com/Singer_Audio5/ChuyenBaMuaMua-QuangLe-2555549.mp3?st=mgY3NB-wvoy8D0vZYRhVeg&e=1626319091",
    //                 title: "Chuyện Ba Mùa Mưa",
    //                 url: "https://www.nhaccuatui.com/bai-hat/chuyen-ba-mua-mua-quang-le.qA12txRu8N2v.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/04/18/6/6/0/8/1492499750133.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/04/18/6/6/0/8/1492499750133_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Mạnh Quỳnh, Trường Vũ, Mạnh Đình",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/01/02/e/6/f/c/1483344191448.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui946/LienKhucNgheo-ManhQuynhTruongVuManhDinh-1154219.mp3?st=L7PwdYBUkgTvmOV9DSUlAA&e=1626319091",
    //                 title: "Liên Khúc Nghèo",
    //                 url: "https://www.nhaccuatui.com/bai-hat/lien-khuc-ngheo-manh-quynh-ft-truong-vu-ft-manh-dinh.ALOKU3D4dk.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2018/02/09/a/4/8/8/1518146788375.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên, Mai Thiên Vân",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/02/07/c/6/d/c/1486452549120.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui936/XaNguoiMinhYeu-DanNguyenMaiThienVan-4761268.mp3?st=W5077TW-SNgjfsvCBr7YzQ&e=1626319091",
    //                 title: "Xa Người Mình Yêu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/xa-nguoi-minh-yeu-dan-nguyen-ft-mai-thien-van.iqCFwSzCEBsV.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Hoài Lâm",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/11/27/c/3/c/0/1480214069575.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui934/TromNhinNhau-HoaiLam-4677141.mp3?st=55YDGxNBNydkfXPv6b72jg&e=1626319091",
    //                 title: "Trộm Nhìn Nhau",
    //                 url: "https://www.nhaccuatui.com/bai-hat/trom-nhin-nhau-hoai-lam.TBcBZcXuDtfb.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Hoài Lâm",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/07/01/0/e/b/f/1435718855678.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui935/NgaiNgung-HoaiLam-4031860.mp3?st=nOen9Q9kSe4YJXCgqub9cg&e=1626319091",
    //                 title: "Ngại Ngùng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ngai-ngung-hoai-lam.D3v7NomkVLOp.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/07/25/0/e/3/2/1564040499706.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/11/28/b/a/d/9/1543393481989_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Như Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui1016/VongGacDemSuong-NhuQuynh-442773.mp3?st=UWX6s7hy3tchfMfR7L19KA&e=1626319091",
    //                 title: "Vọng Gác Đêm Sương",
    //                 url: "https://www.nhaccuatui.com/bai-hat/vong-gac-dem-suong-nhu-quynh.5eJFU6SIe_.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717828993.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717828993_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Bằng Kiều",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/07/25/9/a/0/5/1437800535728.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui156/EmLaTatCa-BangKieu_35rew.mp3?st=Kk8EjUq8bpaQQSsLhHRGCQ&e=1626319091",
    //                 title: "Em Là Tất Cả",
    //                 url: "https://www.nhaccuatui.com/bai-hat/em-la-tat-ca-bang-kieu.zYzqoeLxfMxy.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Hoài Lâm",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/07/01/0/e/b/f/1435735405082.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui936/KiepNgheo-HoaiLam-4031373.mp3?st=uKmlLrSbo1ck09aBzsFtEw&e=1626319091",
    //                 title: "Kiếp Nghèo",
    //                 url: "https://www.nhaccuatui.com/bai-hat/kiep-ngheo-hoai-lam.XFc2KnGYEOcZ.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/10/11/8/b/6/9/1539233476275.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui936/MotNgayKhongCoEm-DanNguyen-2677555.mp3?st=Ur89sq67yskczgL3sGhztQ&e=1626319091",
    //                 title: "Một Ngày Không Có Em",
    //                 url: "https://www.nhaccuatui.com/bai-hat/mot-ngay-khong-co-em-dan-nguyen.NTsdYh00JhgE.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717096314.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717096314_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Duy Quang, Khánh Hà, Tuấn Ngọc, Khánh Ly",
    //                 lyric: "https://lrc-nct.nixcdn.com/null",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui842/LkNgoThuyMien-DangCapNhat-2802826.mp3?st=j04LhxUVEuH86FUurqLuvg&e=1626319091",
    //                 title: "Liên Tình Khúc Ngô Thụy Miên",
    //                 url: "https://www.nhaccuatui.com/bai-hat/lien-tinh-khuc-ngo-thuy-mien-duy-quang-ft-khanh-ha-ft-tuan-ngoc-ft-khanh-ly.dsxpqlmTgQg6.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2019/07/25/0/e/3/2/1564043972183.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/01/25/4/1/1/7/1453717828993_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Bằng Kiều",
    //                 lyric: "https://lrc-nct.nixcdn.com/2014/10/12/8/5/2/f/1413117974555.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui932/EmOiHaNoiPho-BangKieu-3145883.mp3?st=nUfk5ASoM10JcX6ScbIOSw&e=1626319091",
    //                 title: "Em Ơi Hà Nội Phố",
    //                 url: "https://www.nhaccuatui.com/bai-hat/em-oi-ha-noi-pho-bang-kieu.RghVuzkPJrro.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/06/16/f/9/d/4/1466072762039.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/06/16/f/9/d/4/1466072762039_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Dương Ngọc Thái",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/01/20/b/e/0/9/1421758360675.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui196/GoiDo-DuongNgocThai_3hf63.mp3?st=on7AlyR0KJyDEoi0Eo0BzA&e=1626319091",
    //                 title: "Gọi Đò",
    //                 url: "https://www.nhaccuatui.com/bai-hat/goi-do-duong-ngoc-thai.12A9d4bzX2k7.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/01/11/8/a/6/c/1515660718081.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2018/01/11/8/a/6/c/1515660718081_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Phi Nhung, Mạnh Quỳnh",
    //                 lyric: "https://lrc-nct.nixcdn.com/2019/03/07/4/b/e/4/1551951199445.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui180/ThiepHongAnhVietTenEm-PhiNhung-Ma_3ca98.mp3?st=twfzcRwiaYFAImFmytOX2Q&e=1626319091",
    //                 title: "Thiệp Hồng Anh Viết Tên Em",
    //                 url: "https://www.nhaccuatui.com/bai-hat/thiep-hong-anh-viet-ten-em-phi-nhung-ft-manh-quynh.qY8TNV5oUSJL.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/30/4/4/8/6/1606732540593.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/30/4/4/8/6/1606732540593_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lê Hiếu",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/08/10/9/e/6/0/1439197996805.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui239/EmVeTinhKhoi-LeHieu_8a.mp3?st=-grQ0S1yspuA8NS-IGi2ZA&e=1626319091",
    //                 title: "Em Về Tinh Khôi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/em-ve-tinh-khoi-le-hieu.dRUCsj7td3Up.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/05/27/6/9/5/0/1590568952971_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Hoài Lâm",
    //                 lyric: "https://lrc-nct.nixcdn.com/2015/05/21/6/2/7/0/1432192493293.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui896/PhoBuon-HoaiLam-3909509.mp3?st=dlS6cNsw5xXXNabKl6yHZg&e=1626319091",
    //                 title: "Phố Buồn",
    //                 url: "https://www.nhaccuatui.com/bai-hat/pho-buon-hoai-lam.MOAIi8W6YDMi.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/25/e/6/6/d/1624608342985.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2013/16114_LuongKhanhVy_A_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Lương Khánh Vy",
    //                 lyric: "https://lrc-nct.nixcdn.com/2021/07/01/0/e/0/f/1625129453259.lrc",
    //                 music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/ConGaiMienTay-LuongKhanhVy-7037388.mp3?st=aTwxBt1k6MeQDd4owzCdJw&e=1626319091",
    //                 title: "Con Gái Miền Tây",
    //                 url: "https://www.nhaccuatui.com/bai-hat/con-gai-mien-tay-luong-khanh-vy.NGmk9uOl2onL.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2018/02/09/a/4/8/8/1518146745063.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/02/07/c/6/d/c/1486442347910.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui936/KhongConNhoNguoiYeu-DanNguyen-4761258.mp3?st=0RUyvwJRBpExDMLJdonqHQ&e=1626319091",
    //                 title: "Không Còn Nhớ Người Yêu",
    //                 url: "https://www.nhaccuatui.com/bai-hat/khong-con-nho-nguoi-yeu-dan-nguyen.MsamO0fL9EZ6.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/09/07/c/0/a/5/1504771997207.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/09/07/c/0/a/5/1504771997207_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Quỳnh Trang",
    //                 lyric: "https://lrc-nct.nixcdn.com/2016/12/15/b/7/8/0/1481753598383.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui932/GoCuaTraiTim-QuynhTrang-4706741.mp3?st=zUIhhjikppyqNn5K0rY2Sw&e=1626319091",
    //                 title: "Gõ Cửa Trái Tim",
    //                 url: "https://www.nhaccuatui.com/bai-hat/go-cua-trai-tim-quynh-trang.Tc407x5GHLW9.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2018/07/12/b/1/9/3/1531391262307.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2016/04/25/7/5/a/1/1461556928584_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Dương Hồng Loan",
    //                 lyric: "https://lrc-nct.nixcdn.com/2018/12/05/5/1/6/4/1543983541171.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui966/PhanGaiLoLang-DuongHongLoan-5524060.mp3?st=vAAQDNXJS6P6sHXriojHoQ&e=1626319091",
    //                 title: "Phận Gái Lỡ Làng",
    //                 url: "https://www.nhaccuatui.com/bai-hat/phan-gai-lo-lang-duong-hong-loan.7MFsztcp3TzC.html",
    //             },
    //             {
    //                 avatar: "https://avatar-ex-swe.nixcdn.com/song/2018/02/09/a/4/8/8/1518146768831.jpg",
    //                 bgImage:
    //                     "https://avatar-ex-swe.nixcdn.com/singer/avatar/2017/03/24/8/2/a/2/1490321288901_600.jpg",
    //                 coverImage:
    //                     "https://avatar-ex-swe.nixcdn.com/playlist/2020/09/16/e/1/f/f/1600244061118_500.jpg",
    //                 creator: "Đan Nguyên",
    //                 lyric: "https://lrc-nct.nixcdn.com/2017/02/07/c/6/d/c/1486451447181.lrc",
    //                 music: "https://aredir.nixcdn.com/NhacCuaTui936/NgayEmDi-DanNguyen-4761264.mp3?st=W7HIJLQppo66zApzpj8Wvg&e=1626319091",
    //                 title: "Ngày Em Đi",
    //                 url: "https://www.nhaccuatui.com/bai-hat/ngay-em-di-dan-nguyen.RNXN9mQ0FWMF.html",
    //             },
    //         ],
    //     },
    // ];

    // const songs = [
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/12/e/2/9/e/1615554946033.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/07/13/0/6/d/2/1626145766324_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Phúc Chinh",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/03/22/2/8/d/4/1616360845396.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1012/TheLuong-PhucChinh-6971140.mp3?st=nEd9QKrDPq7PGNbD-zxdEw&e=1626319087",
    //         title: "Thê Lương",
    //         url: "https://www.nhaccuatui.com/bai-hat/the-luong-phuc-chinh.nmxw6tXZyBQy.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/04/29/9/1/f/8/1619691182261.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/05/12/7/d/c/b/1620802736418_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Sơn Tùng M-TP",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/05/07/a/9/f/2/1620357842616.lrc",
    //         music: "https://aredir.nixcdn.com/Believe_Audio19/MuonRoiMaSaoCon-SonTungMTP-7011803.mp3?st=uPqHA1vdgUDNNYcvqr2oaA&e=1626319087",
    //         title: "Muộn Rồi Mà Sao Còn",
    //         url: "https://www.nhaccuatui.com/bai-hat/muon-roi-ma-sao-con-son-tung-m-tp.6nAqBAZ3nxuV.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/07/03/e/9/6/f/1625303286239.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/07/05/7/5/8/a/1625467381647_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Kay Trần",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/07/10/2/9/b/8/1625892644539.lrc",
    //         music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/NamDoiBanTay-KayTran-7042104.mp3?st=6pYOfWWdl4U4kGfONAqM2A&e=1626319087",
    //         title: "Nắm Đôi Bàn Tay",
    //         url: "https://www.nhaccuatui.com/bai-hat/nam-doi-ban-tay-kay-tran.xcNnXdzdGWuz.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/05/30/2/6/7/5/1622365032910.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/06/29/3/c/a/6/1624943867794_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "JSOL, Hoàng Duyên",
    //         lyric: "https://lrc-nct.nixcdn.com/null",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1016/SaiGonHomNayMua-JSOLHoangDuyen-7026537.mp3?st=f16ipo_DAUCt5IrH0ROdYQ&e=1626319087",
    //         title: "Sài Gòn Hôm Nay Mưa",
    //         url: "https://www.nhaccuatui.com/bai-hat/sai-gon-hom-nay-mua-jsol-ft-hoang-duyen.EZwfyBx9IT1N.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/27/d/2/9/1/1616859493571.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/03/30/c/2/0/6/1617079270471_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Hứa Kim Tuyền, Hoàng Duyên",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/03/29/0/3/e/5/1616991024586.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1013/SaiGonDauLongQua-HuaKimTuyenHoangDuyen-6992977.mp3?st=x1GxaN-Lghaa7kTWfv-wnA&e=1626319087",
    //         title: "Sài Gòn Đau Lòng Quá",
    //         url: "https://www.nhaccuatui.com/bai-hat/sai-gon-dau-long-qua-hua-kim-tuyen-ft-hoang-duyen.2hI4xFTa2lxJ.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/28/8/4/3/c/1624872522478.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/03/15/4/7/7/8/1615802750962_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "X2X",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/07/08/6/e/d/5/1625714895877.lrc",
    //         music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/TracTro-X2X-7040184.mp3?st=tET44tS3Z9zaQBHOU0TT0w&e=1626319087",
    //         title: "Trắc Trở",
    //         url: "https://www.nhaccuatui.com/bai-hat/trac-tro-x2x.euuuwjUAqLcX.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/04/14/c/3/3/b/1618383513976.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/04/14/b/9/8/b/1618374024681_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Phát Huy T4, Truzg",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/04/19/b/1/b/6/1618802396072.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1014/PhanDuyenLoLang-PhatHuyT4Trugz-7004538.mp3?st=cmeoDQ2Flg2sr29js9adFw&e=1626319087",
    //         title: "Phận Duyên Lỡ Làng",
    //         url: "https://www.nhaccuatui.com/bai-hat/phan-duyen-lo-lang-phat-huy-t4-ft-truzg.ipBDxxA22NUf.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/06/18/d/c/e/c/1623989997901.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/02/c/4/b/1/1604299335097_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Hương Ly",
    //         lyric: "https://lrc-nct.nixcdn.com/null",
    //         music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/NeuCoKiepSau-HuongLy-7034940.mp3?st=cBOUKw70kk42JBLtL_FN8Q&e=1626319087",
    //         title: "Nếu Có Kiếp Sau",
    //         url: "https://www.nhaccuatui.com/bai-hat/neu-co-kiep-sau-huong-ly.ERV3kZbvf716.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/25/0/b/f/e/1616662504016.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/12/14/2/5/3/b/1607910088022_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Anh Rồng",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/03/31/f/4/c/b/1617161486413.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1013/VachNgocNga-AnhRong-6984991.mp3?st=LbscIMZoVMQvxKN5QOr8iQ&e=1626319087",
    //         title: "Vách Ngọc Ngà",
    //         url: "https://www.nhaccuatui.com/bai-hat/vach-ngoc-nga-anh-rong.Rk1SNs5dI0Nf.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/07/31/c/5/8/9/1596188259603.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/09/19/1/e/f/8/1568871085871_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Hoàng Dũng",
    //         lyric: "https://lrc-nct.nixcdn.com/2020/08/04/a/7/a/5/1596551789790.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1001/NangTho-HoangDung-6413381.mp3?st=7lqH8RvKNIOvmqekiTRViw&e=1626319087",
    //         title: "Nàng Thơ",
    //         url: "https://www.nhaccuatui.com/bai-hat/nang-tho-hoang-dung.Kx3Kbih0rS5z.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/11/05/4/4/6/c/1604574284072.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/05/2/2/0/3/1604563630516_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "MIN",
    //         lyric: "https://lrc-nct.nixcdn.com/2020/11/05/9/5/c/9/1604562096053.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1005/TrenTinhBanDuoiTinhYeu-MIN-6802163.mp3?st=_2rEAKiDlRhGhq9Td0KiJA&e=1626319087",
    //         title: "Trên Tình Bạn Dưới Tình Yêu",
    //         url: "https://www.nhaccuatui.com/bai-hat/tren-tinh-ban-duoi-tinh-yeu-min.adEZfVuRfAhW.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/03/29/2/2/1/e/1617029681297.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/09/22/5/3/5/d/1600744344048_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Đình Dũng, ACV",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/04/05/9/f/3/8/1617596589191.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1013/CauHenCauThe-DinhDung-6994741.mp3?st=sn5VtOQm53HxCLjMX9d94A&e=1626319087",
    //         title: "Câu Hẹn Câu Thề",
    //         url: "https://www.nhaccuatui.com/bai-hat/cau-hen-cau-the-dinh-dung-ft-acv.DT1Ev3vytaQo.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/07/06/7/a/3/0/1625546620298.jpg",
    //         bgImage: "",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Changg, Minh Huy",
    //         lyric: "https://lrc-nct.nixcdn.com/null",
    //         music: "https://f9-stream.nixcdn.com/NhacCuaTui1017/EmKhongHieu-ChanggMinhHuy-7043556.mp3?st=MAwB0EIzJ33fQNVoHFmGeA&e=1626319087",
    //         title: "Em Không Hiểu",
    //         url: "https://www.nhaccuatui.com/bai-hat/em-khong-hieu-changg-ft-minh-huy.gWRtS5SiJInk.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/02/10/6/5/a/6/1612954164434.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2021/02/17/a/3/2/1/1613561860337_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Juky San, RedT",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/03/08/5/c/4/b/1615219017101.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1011/PhaiChangEmDaYeu-JukySanRedT-6940932.mp3?st=7iX3YWIU9m5X1Jxk3ciA2w&e=1626319087",
    //         title: "Phải Chăng Em Đã Yêu?",
    //         url: "https://www.nhaccuatui.com/bai-hat/phai-chang-em-da-yeu-juky-san-ft-redt.MRUP1c69kN0R.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/01/21/5/c/9/9/1611199600529.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2019/11/08/2/2/a/0/1573196340329_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Lemese, Changg",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/03/08/5/c/4/b/1615219651901.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1010/LoSayByeLaBye-LemeseChangg-6926941.mp3?st=gaK37RnI4LWtlivT9YcCLA&e=1626319087",
    //         title: "Lỡ Say Bye Là Bye",
    //         url: "https://www.nhaccuatui.com/bai-hat/lo-say-bye-la-bye-lemese-ft-changg.QLdwL2NxwFA5.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2021/01/27/5/2/2/b/1611738358661.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/08/12/f/2/d/1/1597199590443_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "T.R.I",
    //         lyric: "https://lrc-nct.nixcdn.com/2021/03/08/5/c/4/b/1615219421510.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1010/ChungTaSauNay-TRI-6929586.mp3?st=UjOpc48tSNvkviwS25h9tg&e=1626319087",
    //         title: "Chúng Ta Sau Này",
    //         url: "https://www.nhaccuatui.com/bai-hat/chung-ta-sau-nay-tri.61Wkf72FX7be.html",
    //     },
    //     {
    //         avatar: "https://avatar-ex-swe.nixcdn.com/song/2020/10/12/0/7/e/3/1602477673421.jpg",
    //         bgImage:
    //             "https://avatar-ex-swe.nixcdn.com/singer/avatar/2020/11/02/c/4/b/1/1604299335097_600.jpg",
    //         coverImage:
    //             "https://avatar-ex-swe.nixcdn.com/playlist/2021/05/04/3/b/6/d/1620100988545_500.jpg",
    //         creator: "Hương Ly",
    //         lyric: "https://lrc-nct.nixcdn.com/2020/10/13/7/4/f/8/1602557634151.lrc",
    //         music: "https://aredir.nixcdn.com/NhacCuaTui1004/TheThai-HuongLy-6728509.mp3?st=-Er2GMdd1wIBsFLOKUzatA&e=1626319087",
    //         title: "Thế Thái",
    //         url: "https://www.nhaccuatui.com/bai-hat/the-thai-huong-ly.73T5LuURl5Bo.html",
    //     },
    // ];
});
