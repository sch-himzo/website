@extends('layouts.main')

@section('title','DST Kirajzolás')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Színválasztás</h3>
                </div>
                <form action="{{ route('designs.colors', ['design' => $design]) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="colors" value="{{ $color_count }}">
                    <input type="hidden" name="diameter" value="{{ $diameter }}">
                    <input type="hidden" name="xoffset" value="{{ abs($minx) }}">
                    <input type="hidden" name="yoffset" value="{{ abs($miny) }}">
                    <input type="hidden" name="height" value="{{ $height }}">
                    <input type="hidden" name="width" value="{{ $width }}">
                    <div class="panel-body">
                        <div class="color-select">

                            @if(count($design->colors) == 0)
                            @for($i = 0; $i<$color_count; $i++)
                                <input type="hidden" name="color_stitches_{{ $i }}" value="{{ sizeof($stitches[$i]) }}">
                                <input type="hidden" name="r_{{ $i }}" id="r_{{ $i }}" value="">
                                <input type="hidden" name="g_{{ $i }}" id="g_{{ $i }}" value="">
                                <input type="hidden" name="b_{{ $i }}" id="b_{{ $i }}" value="">
                                <div class="color">
                                    {{ $i+1 }}. szín:
                                    <label id="color_isa_{{ $i }}"><input checked name="color_isa_{{ $i }}" type="radio" value="isa"> Isacord</label>
                                    <label id="color_sulky_{{ $i }}"><input name="color_isa_{{ $i }}" type="radio" value="sulky"> Sulky</label>
                                    <input type="text" class="form-control" name="color_{{ $i }}" placeholder="Színkód" id="icolor_{{ $i }}">
                                </div>
                            @endfor
                            @else
                                <?php $i = 0; ?>
                                @foreach($design->colors as $color)
                                    <input type="hidden" name="color_stitches_{{ $i }}" value="{{ array_key_exists($i, $stitches) ? sizeof($stitches[$i]) : '' }}">
                                    <input type="hidden" name="r_{{ $i }}" id="r_{{ $i }}" value="{{ $color->red }}">
                                    <input type="hidden" name="g_{{ $i }}" id="g_{{ $i }}" value="{{ $color->green }}">
                                    <input type="hidden" name="b_{{ $i }}" id="b_{{ $i }}" value="{{ $color->blue }}">
                                        <div class="color">
                                            <?= $i+1 ?>. szín:
                                            <label id="color_isa_<?= $i ?>>"><input {{ $color->isacord ? "checked" : "" }} name="color_isa_<?= $i ?>" type="radio" value="isa"> Isacord</label>
                                            <label id="color_sulky_<?= $i ?>"><input {{ $color->isacord ? "" : "checked" }} name="color_isa_<?= $i ?>" type="radio" value="sulky"> Sulky</label>
                                            <input value="{{ $color->code }}" type="text" class="form-control" name="color_<?= $i ?>" placeholder="Színkód" id="icolor_<?= $i ?>">
                                        </div>
                                    <?php $i++; ?>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="color-select">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="background" class="input-group-addon">Háttér</label>
                                    <select class="form-control" id="background" name="background" required>
                                        <option disabled selected>Válassz egyet</option>
                                        @foreach($backgrounds as $background)
                                            <option @if($background==$current_background) selected @endif value="{{ $background->id }}" style="background:rgb({{ $background->red }}, {{ $background->green }}, {{ $background->blue }} );">{{ $background->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="submit" value="Mentés" class="btn btn-primary">
                        @if($order!=null)
                        <a href="{{ route('orders.view', ['group' => $order->group, 'order' => $order]) }}" class="btn btn-default">Vissza a rendeléshez</a>
                        @else
                        <a href="javascript:history.back()" class="btn btn-default">Vissza</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8" style="position:relative;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Rajzolat</h3>
                </div>
                <div class="panel-body">
                    <svg style="@if($current_background!=null) background-color:rgb({{ $current_background->red }}, {{ $current_background->green }}, {{ $current_background->blue }} ); @endif" id="image" class="svg" viewBox="0 0 {{ $width }} {{ $height }}" preserveAspectRatio="none" style="margin:auto;">
                        @foreach($stitches as $id => $color)
                            @if($design->colors->count()==0)
                                <g id="color_{{ $id }}" style="stroke:#000000">
                                    @else
                                        <g id="color_{{ $id }}" style="stroke:{{ $colors[$id] }};">
                                            @endif
                                            @foreach($color as $stitch)
                                                <line x1="{{ $stitch[0][0]+abs($minx)+5 }}" x2="{{ $stitch[1][0]+abs($minx)+5 }}" y1="{{ $stitch[0][1]+abs($miny)+5 }}" y2="{{ $stitch[1][1]+abs($miny)+5 }}" style="stroke-width:2;"></line>
                                            @endforeach
                                        </g>
                                @endforeach
                    </svg>
                </div>
                <div class="panel-footer">

                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var backgrounds = {
            @foreach($backgrounds as $background)
                '{{ $background->id }}': [ {{ $background->red }}, {{ $background->green }}, {{ $background->blue }}],
            @endforeach
        }
        var isa_rgb = {
            '5326':['#346043'],
            '5633':['#0C4C12'],
            '5414':['#026F5B'],
            '5500':['#36D182'],
            '5832':['#83C975'],
            '5912':['#75B83C'],
            '6031':['#CEE738'],
            '5940':['#C3FC8B'],
            '6010':['#DDF33C'],
            '0220':['#F1E976'],
            '0520':['#E7D58A'],
            '0600':['#F8EC68'],
            '0703':['#FCDA6A'],
            '1030':['#F5A762'],
            '1352':['#E8926C'],
            '0800':['#EC9D1F'],
            '1321':['#E5602F'],
            '0904':['#F8BC52'],
            '0824':['#DB9027'],
            '0721':['#C0994A'],
            '0651':['#CDAF86'],
            '0842':['#C28151'],
            '1154':['#A66D5D'],
            '1344':['#772921'],
            '1366':['#492B34'],
            '2123':['#7B1B2C'],
            '1912':['#9D1A2F'],
            '2101':['#B81423'],
            '1704':['#F03634'],
            '2300':['#D61A50'],
            '2153':['#EEB2C2'],
            '2170':['#FAECFB'],
            '2530':['#FE98C2'],
            '2732':['#CA50C0'],
            '3030':['#AC89C1'],
            '2702':['#7236A9'],
            '3333':['#1D2372'],
            '4515':['#1C3F5D'],
            '4133':['#153369'],
            '3732':['#2D3B66'],
            '3622':['#143A92'],
            '3510':['#0434C9'],
            '3323':['#131D5E'],
            '3900':['#0089E2'],
            '4421':['#19779E'],
            '4423':['#026FA2'],
            '4220':['#4FC0E1'],
            '3910':['#5CBCE4'],
            '3815':['#4093D5'],
            '3652':['#C4CBE7'],
            '4952':['#AED1D5'],
            '0150':['#D3CCD2'],
            '0105':['#C1BCC1'],
            '0108':['#71656E'],
            '4174':['#20232D'],
            '0020':['#000000'],
            '0010':['#ffffff']
        };
        var sulky_isa = {
            '505':'3444',
            '520':'0870',
            '521':'1032',
            '523':'0821',
            '524':'3344',
            '525':'5353',
            '526':'3522',
            '534':'2113',
            '538':'5335',
            '561':'1902',
            '567':'0811',
            '568':'0922',
            '569':'5515',
            '571':'5010',
            '572':'3335',
            '580':'5542',
            '610':'7369',
            '621':'1311',
            '622':'0713',
            '630':'5934',
            '640':'4610',
            '1001':'0015',
            '1002':'0010',
            '1005':'0020',
            '1011':'0142',
            '1017':'1060',
            '1019':'1351',
            '1022':'0270',
            '1023':'0600',
            '1024':'0702',
            '1025':'0821',
            '1028':'3641',
            '1029':'3820',
            '1030':'3331',
            '1031':'3045',
            '1032':'2830',
            '1034':'1921',
            '1035':'2123',
            '1037':'1800',
            '1039':'1900',
            '1040':'0152',
            '1042':'3543',
            '1043':'3355',
            '1044':'3354',
            '1046':'5020',
            '1049':'5531',
            '1051':'5415',
            '1054':'1140',
            '1055':'0851',
            '1056':'0935',
            '1057':'0933',
            '1058':'1355',
            '1059':'1876',
            '1061':'0260',
            '1064':'2170',
            '1065':'1200',
            '1066':'0520',
            '1067':'0230',
            '1070':'8543',
            '1071':'0670',
            '1074':'3951',
            '1076':'3611',
            '1078':'1304',
            '1079':'5411',
            '1080':'2640',
            '1081':'1725',
            '1086':'0670',
            '1090':'4531',
            '1094':'4103',
            '1095':'4111',
            '1096':'4116',
            '1100':'5650',
            '1101':'5411',
            '1103':'5866',
            '1104':'6051',
            '1108':'2155',
            '1109':'2520',
            '1112':'3110',
            '1113':'1860',
            '1115':'2250',
            '1119':'2241',
            '1120':'2170',
            '1121':'2250',
            '1122':'2905',
            '1124':'0506',
            '1126':'1032',
            '1127':'0761',
            '1128':'0853',
            '1131':'1776',
            '1134':'7240',
            '1135':'0630',
            '1137':'0702',
            '1147':'1800',
            '1148':'1840',
            '1149':'1172',
            '1151':'4250',
            '1154':'1753',
            '1156':'6133',
            '1158':'1355',
            '1159':'0542',
            '1162':'4515',
            '1166':'0110',
            '1167':'0630',
            '1168':'1102',
            '1169':'1912',
            '1170':'0925',
            '1172':'3842',
            '1173':'0354',
            '1174':'5555',
            '1175':'5944',
            '1177':'5832',
            '1179':'0945',
            '1180':'0862',
            '1181':'1335',
            '1182':'3344',
            '1183':'1776',
            '1184':'1304',
            '1185':'0600',
            '1186':'1346',
            '1187':'0600',
            '1188':'1753',
            '1189':'2336',
            '1190':'2241',
            '1192':'2500',
            '1193':'3030',
            '1194':'2920',
            '1195':'3114',
            '1196':'3820',
            '1197':'3353',
            '1199':'3244',
            '1200':'3323',
            '1201':'3830',
            '1202':'4133',
            '1203':'4250',
            '1204':'4250',
            '1206':'4643',
            '1208':'5233',
            '1210':'0465',
            '1211':'0463',
            '1216':'1332',
            '1217':'1344',
            '1218':'0151',
            '1219':'2564',
            '1220':'0111',
            '1222':'3840',
            '1223':'3951',
            '1224':'2560',
            '1225':'2160',
            '1226':'3332',
            '1227':'0442',
            '1229':'0672',
            '1230':'5005',
            '1231':'2300',
            '1233':'4644',
            '1234':'4174',
            '1235':'3110',
            '1238':'1200',
            '1240':'0112',
            '1241':'0132',
            '1243':'0221',
            '1245':'0442',
            '1247':'1366',
            '1248':'3962',
            '1249':'3910',
            '1251':'4113',
            '1252':'4103',
            '1254':'3030',
            '1255':'2810',
            '1256':'2532',
            '1258':'1362',
            '1259':'1430',
            '1261':'0600',
            '1262':'0546',
            '1263':'1514',
            '1265':'0833',
            '1267':'1055',
            '1269':'0862',
            '1271':'5353',
            '1273':'5866',
            '1275':'5450',
            '1277':'5513',
            '1278':'5613',
            '1279':'5440',
            '1280':'5230',
            '1281':'5101',
            '1282':'5100',
            '1284':'3842',
            '1285':'4643',
            '1287':'5644',
            '1290':'3900',
            '1291':'3953',
            '1292':'3652',
            '1293':'3323',
            '1294':'7088',
            '1297':'2864',
            '1299':'3536',
            '1300':'2711',
            '1301':'3110',
            '1302':'3210',
            '1303':'1840',
            '1305':'4752',
            '1308':'2302',
            '1309':'2333',
            '1310':'2210',
            '1311':'2011',
            '1312':'2123',
            '1314':'1300',
            '1315':'1304',
            '1317':'1701',
            '1319':'1800',
            '1321':'0672',
            '1323':'0576',
            '1328':'0108',
            '1329':'0131',
            '1331':'5650',
            '1332':'5832',
            '1334':'0542',
            '1503':'5115',
            '1508':'0463',
            '1511':'2320',
            '1513':'4423',
            '1517':'5005',
            '1533':'2300',
            '1534':'3901',
            '1535':'3612',
            '1536':'5374'
        };

        var background = $('#background');


        $(background).on('load paste keyup click change', function(){
            console.log(backgrounds[background.val()]);
            $('#image').css('background-color','rgb(' + backgrounds[background.val()][0] +', ' + backgrounds[background.val()][1] + ', ' + backgrounds[background.val()][2] + ')');
        });


        @for($i = 0; $i<$color_count; $i++)

            $('#icolor_{{ $i }}').focusout(function(){
                console.log('blur');
                @for($j = 0; $j<$color_count; $j++)
                    code = $('#icolor_{{ $j }}').val();
                if($('input[name=color_isa_{{ $j }}]:checked').val()==='isa'){
                    rgb = isa_rgb[code];
                }else if($('input[name=color_isa_{{ $j }}]:checked').val()==='sulky'){
                    isa = sulky_isa[code];
                    rgb = isa_rgb[isa];
                }else{
                    rgb = ['#000000'];
                }
                if(rgb===undefined){
                    rgb= ['#000000'];
                }
                $('#color_{{ $j }}').attr('style','stroke:' + rgb[0] + ';');
                @endfor
            });
            $('#icolor_{{ $i }}, #color_isa_{{ $i }}, #color_sulky_{{ $i }}').on('focus paste click keyup', function(){
                console.log('focus');
                code = $('#icolor_{{ $i }}').val();
                console.log(code);
                if($('input[name=color_isa_{{ $i }}]:checked').val()==='isa'){
                    rgb = isa_rgb[code];
                }else if($('input[name=color_isa_{{ $i }}]:checked').val()==='sulky'){
                    isa = sulky_isa[code];
                    rgb = isa_rgb[isa];
                }else{
                    rgb = ['#000000'];
                }
                if(rgb===undefined){
                    rgb=['#000000'];
                }
                $('#r_{{ $i }}').val(rgb[0]);
                $('#color_{{ $i }}').attr('style','stroke:' + rgb[0]);
                @for($j = 0; $j<$color_count; $j++)
                    @if($j!=$i)
                        $('#color_{{ $j }}').attr('style','stroke:rgb(127,127,127)');
                    @endif
                @endfor
            });

        @endfor
    </script>
@endsection
