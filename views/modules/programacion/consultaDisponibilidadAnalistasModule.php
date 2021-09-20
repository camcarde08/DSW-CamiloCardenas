<script type="text/javascript">
$(document).ready(function () {
    
    initialConsultaDisponibilidadUsuarios();
    
});
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h1>Consulta de Disponibilidad de Usuarios</h1>
</div>

<div style="border-style: solid; border: 0; width: 100%; height: auto">
    <div style="border-style: solid; border: 0; width: 100%; height: auto">
        <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff;height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; margin-bottom: 12px;  padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
            Usuario a Consultar
        </div>
        <!--            renglon1-->
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Nombre del Analista:</span>
            </div>
            <div style="width: 400px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="inputAnalistaNombre">
                    <input id="textInputAnalistaNombre" type="text" name="numMuestra"/>
                    <div id="inputButtonChargeAnalistaInfo"><img alt="search" width="16" height="16" src="views/images/search_lg.png" /></div>
                </div>
            </div>
            <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left"> 
                <input type="button" name="clearButton" id="clearButton" value="Limpiar" />
            </div>
        </div>
        
        <div id="headerCalendarioAnalista" style="font-family: Verdana ;font-weight:bold ; color:#ffffff;height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; margin-bottom: 12px;  padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
            Calendario del Analista:
        </div>
        <!--            renglon-->
        <div style="border-style: solid; border: 0; height: 470px; background-color: white; padding-top: 0px; overflow: auto">
            <div style="width: 280px; height: auto; overflow: hidden; float: left; border: 0px solid blue">
                <div style="width: 280px; height: 280px; float: left; overflow: hidden;border: 0px solid red">
                    <div id="principalDivCalendar" style="margin-left: 20px; width: 240px; height: auto; border-radius: 10px 10px 10px 10px; float: left; font-family: Verdana; font-size: 13px; border-style: solid; border:0">
                        <div style="background: #999; text-align: center; height: auto; overflow: hidden; border-style: solid; border: 0;border-radius: 10px 10px 0px 0px;">

                            <div style="padding-top: 5px; padding-left: 5px; width: 5%;height: 20px; float: left;border-style: solid; border: 0">
                                <img src="views/jqwidgets/jqwidgets/styles/images/icon-left.png" onclick="eventClickImageRetrocederCalendario()"/>
                            </div>

                            <div style="padding-top: 5px; padding-right: 5px; width: 20px;height: 20px; float: right;border-style: solid; border: 0">
                                <img src="views/jqwidgets/jqwidgets/styles/images/icon-right.png" onclick="eventClickImageAvansarCalendario()"/>
                            </div>
                            <div id="textHeaderCalendar" style="margin-bottom: 12px; padding-top: 5px; height: 10px; border-style: solid; border: 0">                        
                            </div>



                            <input type="hidden" id="hiddenInputYear">
                            <input type="hidden" id="hiddenInputmonth">

                        </div>
                        <div style="border-style: solid; border-width: thin; border-color: #999; border-radius: 0px 0px 10px 10px">
                            <div style="overflow: hidden; margin-top: 5px; ">
                                <div>
                                    <div style="margin-left: 2px; width: 32px; float: left; border-style: solid; border: 0; text-align: center">Dom</div>
                                    <div style="margin-left: 2px; width: 32px; float: left; border-style: solid; border: 0; text-align: center">Lun</div>
                                    <div style="margin-left: 2px; width: 32px; float: left; border-style: solid; border: 0; text-align: center">Mar</div>
                                    <div style="margin-left: 2px; width: 32px; float: left; border-style: solid; border: 0; text-align: center">Mie</div>
                                    <div style="margin-left: 2px; width: 32px; float: left; border-style: solid; border: 0; text-align: center">Jue</div>
                                    <div style="margin-left: 2px; width: 32px; float: left; border-style: solid; border: 0; text-align: center">Vie</div>
                                    <div style="margin-left: 2px; width: 32px; float: left; border-style: solid; border: 0; text-align: center">Sab</div>
                                </div>
                            </div>
                            <hr>
                            <div id="calendarPrincipal" style="border: 0px solid">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR0C0"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px;">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR0C1"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR0C2"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR0C3"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR0C4"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR0C5"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR0C6"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR1C0"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR1C1"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR1C2"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR1C3"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR1C4"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR1C5"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR1C6"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR2C0"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR2C1"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR2C2"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR2C3"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR2C4"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR2C5"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR2C6"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR3C0"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR3C1"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR3C2"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR3C3"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR3C4"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR3C5"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR3C6"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR4C0"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR4C1"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR4C2"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR4C3"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR4C4"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR4C5"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR4C6"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR5C0"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR5C1"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR5C2"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR5C3"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR5C4"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR5C5"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                            <td style="width: 30px; height: 30px; text-align: center;border-radius: 10px 10px 10px 10px;border-style: solid; border: 0">
                                                <div id="calendarR5C6"  class="divCalendarDay" style="width: 28px; height: 28px; border-radius: 10px 10px 10px 10px; border: 1px solid transparent;  line-height: 30px">1</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
                <div id="divNomenclaturaCalendar" style="margin-top: 10px; float: left">
                    <div style="width: 100%; margin-left: 20px; overflow: hidden">
                        <div style="width: 28px; height: 28px; float: left;border-radius: 10px 10px 10px 10px; background: red"></div>
                        <div style="margin-left: 10px;float: left; font-size: 13px; line-height: 28px">sobreasignación</div>
                    </div>
                    <div style="width: 100%; margin-top: 10px; margin-left: 20px; overflow: hidden">
                        <div style="width: 28px; height: 28px; float: left;border-radius: 10px 10px 10px 10px; background: #000087"></div>
                        <div style="margin-left: 10px;float: left; font-size: 13px; line-height: 28px">Asignación completa</div>
                    </div>
                    <div style="width: 100%; margin-top: 10px; margin-left: 20px; overflow: hidden">
                        <div style="width: 28px; height: 28px; float: left;border-radius: 10px 10px 10px 10px; background: blue"></div>
                        <div style="margin-left: 10px;float: left; font-size: 13px; line-height: 28px">Asignación Parcial</div>
                    </div>

                </div>  
            </div>
            
            <div id="divProncipalGridProgramacionOnDateByIdAnalista" style="margin-right: 20px; width: 900px; height: 430px; padding-top: 5px; border-style: solid; border:0;  float: right">
                <div id="tittleGridProgramacionOnDateByIdAnalista" style="color:#000087; margin-bottom: 10px">Programación  para el analista el dia </div>
                <div id="gridProgramacionOnDateByIdAnalista"></div>
            </div>
            
        </div>
    </div>
    
</div>
<div id="windowDetalleActividad">
    <div>
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 40px; background-color: white; padding-top: 5px">
           <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Muestra:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <input id="inputMuestraWindowDetalleActividad" type="text"/>
            </div>
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Ensayo:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <input id="inputEnsayoWindowDetalleActividad" type="text" />
            </div>
        </div>

        <!--            renglon2-->

        <div style="height: 40px; background-color: #bfbfff; padding-top: 5px">
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Fecha Programación:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <div id="inputCalendarFechaProgramacionWindowDetalleActividad"></div>
            </div>
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Duración de actividad</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <input id="inputDuracionWindowDetalleActividad" type="text" />
            </div>
        </div>
        
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 40px; background-color: white; padding-top: 5px">
           <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Fecha de Finalización:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <div id="inputCalendarFechaFinaliazacionWindowDetalleActividad"></div>
            </div>
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Equipo:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <input id="inputEquipoWindowDetalleActividad" type="text" />
            </div>
        </div>

        <!--            renglon2-->

        <div style="height: 40px; background-color: #bfbfff; padding-top: 5px">
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Area analisis:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <input id="inputAreaAnalisisWindowDetalleActividad" type="text" />
            </div>
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Tipo estabilidad:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <input id="inputTipoEstabilidadWindowDetalleActividad" type="text" />
            </div>
        </div>
        
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 40px; background-color: white; padding-top: 5px">
           <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Programador:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <input id="inputProgramadorWindowDetalleActividad" type="text" />
            </div>
            
        </div>
          <div style="margin-top: 20px; margin-right: 50px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Aceptar" id="buttonOKWindowDetalleActividad"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelWindowDetalleActividad"/>
            </div>
        </div>
    </div>
    <input id="inputHiddenWindowDetalleActividadChangeDateFlag" type="hidden" />
    <input id="inputHiddenWindowDetalleActividadIdActividad" type="hidden" />
    
</div>
<div id="windowAlertDeleteActividad">
    <div id="contenidoAlertDeleteActividad">Prueba</div>
</div>
<input id="inputHiddenSelectedDate" type="hidden" />

