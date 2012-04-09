$(document).ready(function() {
   var $calendar = $('#calendar');
   var id = 10;

   $calendar.weekCalendar({
      // Konfiguration
      timeslotsPerHour : 4,
      allowCalEventOverlap : false,
      overlapEventsSeparate: false,
      longMonths: true,
      firstDayOfWeek : 1,
      businessHours :{start: 7, end: 20, limitDisplay: true},
      daysToShow : 5,
	  switchDisplay: {'1 Tag': 1, '3 Tage': 3, '5 Tage': 5, '7 Tage': 7},
      title: function(daysToShow) {
			return daysToShow == 1 ? '%date%' : '%start% - %end%';
      },
      height : function($calendar) {
        // return $(window).height() - $("h1").outerHeight() - 1;
        return '500';
      },
      // Rendern der einzelnen Termine im Kalender - hier kann vor allem in das Erscheinungsbild eingegriffen werden
      eventRender : function(calEvent, $event) {
         if(calEvent.readOnly == true) {
            $event.css({
                "backgroundColor": "#6c7c8f",
                "background-image" : "url('/public/images/linedbg.png')"
            });
            $event.css("cursor","default");
            $event.find(".wc-time").css({
               "backgroundColor" : "#415775",
               "border" : "1px solid #888",
               "background-image" : "url('/public/images/linedbg.png')"
            });
         }
         if (calEvent.end.getTime() < new Date().getTime()) {
            $event.css("backgroundColor", "#aaa");
            $event.find(".wc-time").css({
               "backgroundColor" : "#999",
               "border" : "1px solid #888"
            });
         }
         
         $event.find(".wc-title").css("color","ff0");
         
      },
      draggable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      resizable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      eventNew : function(calEvent, $event) {
         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var titleField = $dialogContent.find("input[name='title']");
         var bodyField = $dialogContent.find("textarea[name='body']");
         var teilnehmerField = $dialogContent.find("input[name='teilnehmer']");
         var raumid = $dialogContent.find("input[name='raumid']").val();
         var cct = $dialogContent.find("input[name='ci_csrf_token']").val();

         $dialogContent.dialog({
            modal: true,
            title: "Neue Veranstaltung",
            close: function() {
               $('#validation-errors-wrapper').html('');
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               speichern : function() {
                  title = titleField.val();
                  tmp_startdatum = new Date(startField.val());
                  startdatum = tmp_startdatum.getDate() + "." + (tmp_startdatum.getMonth() + 1) + "." + tmp_startdatum.getFullYear() + " " + tmp_startdatum.getHours() + ":" + tmp_startdatum.getMinutes();
                  tmp_endedatum = new Date(endField.val());
                  endedatum = tmp_endedatum.getDate() + "." + (tmp_endedatum.getMonth() + 1) + "." + tmp_endedatum.getFullYear() + " " + tmp_endedatum.getHours() + ":" + tmp_endedatum.getMinutes();
                  teilnehmer = teilnehmerField.val();
                  
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.title = titleField.val();
                  calEvent.body = bodyField.val();
                  calEvent.teilnehmer = teilnehmer;
                  
                  //$dialogContent.dialog("close");
                                    
                   $.post('/veranstaltung/buchen/'+raumid,
                        {   
                            "raumid" : raumid,
                            "name" : title, 
                            "ci_csrf_token" : cct,
                            "startdatum" : startdatum,
                            "enddatum" : endedatum,
                            "teilnehmer" : teilnehmer
                        },
                        function(data){
                             if (data.indexOf("TRUE") >= 0) {
                                $dialogContent.dialog("close");
                                calEvent.id = id;
                                id++;
                                $calendar.weekCalendar("removeUnsavedEvents");
                                $calendar.weekCalendar("updateEvent", calEvent);
                             } else {
                                var jQobj = $(data);
                                jQobj.find('div.errors').addClass('hidden_error');
                                var resultObj = jQobj.filter('#veranstaltung_form').html();
                                $('#validation-errors-wrapper').html(jQobj);
                            }
                        }
                    );

               },
               abbrechen : function() {
                  $('#validation-errors-wrapper').html('');
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));

      },
      eventDrop : function(calEvent, $event) {
                  var $dialogContent = $("#event_edit_container");
                  cct = $dialogContent.find("input[name='ci_csrf_token']").val();
                  title = calEvent.title;
                  tmp_startdatum = new Date(calEvent.start);
                  startdatum = tmp_startdatum.getDate() + "." + (tmp_startdatum.getMonth() + 1) + "." + tmp_startdatum.getFullYear() + " " + tmp_startdatum.getHours() + ":" + tmp_startdatum.getMinutes();
                  tmp_endedatum = new Date(calEvent.end);
                  endedatum = tmp_endedatum.getDate() + "." + (tmp_endedatum.getMonth() + 1) + "." + tmp_endedatum.getFullYear() + " " + tmp_endedatum.getHours() + ":" + tmp_endedatum.getMinutes();
                  teilnehmer = calEvent.teilnehmer;
                                    
                   $.post('/veranstaltung/edit/',
                        {   
                            "uid" : calEvent.id,
                            "raumid" : $dialogContent.find("input[name='raumid']").val(),
                            "name" : title, 
                            "ci_csrf_token" : cct,
                            "startdatum" : startdatum,
                            "enddatum" : endedatum,
                            "teilnehmer" : teilnehmer
                        },
                        function(data){
                             if (data.indexOf("TRUE") >= 0) {
                                $dialogContent.dialog("close");
                                //calEvent.id = id;
                                //id++;
                                $calendar.weekCalendar("removeUnsavedEvents");
                                $calendar.weekCalendar("updateEvent", calEvent);
                             } else {
                                var jQobj = $(data);
                                jQobj.find('div.errors').addClass('hidden_error');
                                var resultObj = jQobj.filter('#veranstaltung_form').html();
                                $('#validation-errors-wrapper').html(jQobj);
                            }
                        }
                    );
      },
      eventResize : function(calEvent, $event) {
                  var $dialogContent = $("#event_edit_container");
                  cct = $dialogContent.find("input[name='ci_csrf_token']").val();
                  title = calEvent.title;
                  tmp_startdatum = new Date(calEvent.start);
                  startdatum = tmp_startdatum.getDate() + "." + (tmp_startdatum.getMonth() + 1) + "." + tmp_startdatum.getFullYear() + " " + tmp_startdatum.getHours() + ":" + tmp_startdatum.getMinutes();
                  tmp_endedatum = new Date(calEvent.end);
                  endedatum = tmp_endedatum.getDate() + "." + (tmp_endedatum.getMonth() + 1) + "." + tmp_endedatum.getFullYear() + " " + tmp_endedatum.getHours() + ":" + tmp_endedatum.getMinutes();
                  teilnehmer = calEvent.teilnehmer;
                                    
                   $.post('/veranstaltung/edit/',
                        {   
                            "uid" : calEvent.id,
                            "raumid" : $dialogContent.find("input[name='raumid']").val(),
                            "name" : title, 
                            "ci_csrf_token" : cct,
                            "startdatum" : startdatum,
                            "enddatum" : endedatum,
                            "teilnehmer" : teilnehmer
                        },
                        function(data){
                             if (data.indexOf("TRUE") >= 0) {
                                $dialogContent.dialog("close");
                                //calEvent.id = id;
                                //id++;
                                $calendar.weekCalendar("removeUnsavedEvents");
                                $calendar.weekCalendar("updateEvent", calEvent);
                             } else {
                                var jQobj = $(data);
                                jQobj.find('div.errors').addClass('hidden_error');
                                var resultObj = jQobj.filter('#veranstaltung_form').html();
                                $('#validation-errors-wrapper').html(jQobj);
                            }
                        }
                    );
      },
      eventClick : function(calEvent, $event) {

         if (calEvent.readOnly) {
            return;
         }

         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var titleField = $dialogContent.find("input[name='title']").val(calEvent.title);
         var bodyField = $dialogContent.find("textarea[name='body']");
         var teilnehmerField = $dialogContent.find("input[name='teilnehmer']").val(calEvent.teilnehmer);
         var raumid = $dialogContent.find("input[name='raumid']").val();
         var cct = $dialogContent.find("input[name='ci_csrf_token']").val();
         bodyField.val(calEvent.body);

         $dialogContent.dialog({
            modal: true,
            title: "Bearbeiten - " + calEvent.title,
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               speichern : function() {
                  title = titleField.val();
                  tmp_startdatum = new Date($dialogContent.find("select[name='start']").val());
                  startdatum = tmp_startdatum.getDate() + "." + (tmp_startdatum.getMonth() + 1) + "." + tmp_startdatum.getFullYear() + " " + tmp_startdatum.getHours() + ":" + tmp_startdatum.getMinutes();
                  tmp_endedatum = new Date($dialogContent.find("select[name='end']").val());
                  endedatum = tmp_endedatum.getDate() + "." + (tmp_endedatum.getMonth() + 1) + "." + tmp_endedatum.getFullYear() + " " + tmp_endedatum.getHours() + ":" + tmp_endedatum.getMinutes();
                  teilnehmer = $dialogContent.find("input[name='teilnehmer']").val();
                  
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.title = titleField.val();
                  calEvent.body = bodyField.val();
                  calEvent.teilnehmer = teilnehmer;
                  
                  //$dialogContent.dialog("close");
                                    
                   $.post('/veranstaltung/edit/',
                        {   
                            "uid" : calEvent.id,
                            "raumid" : $dialogContent.find("input[name='raumid']").val(),
                            "name" : title, 
                            "ci_csrf_token" : cct,
                            "startdatum" : startdatum,
                            "enddatum" : endedatum,
                            "teilnehmer" : teilnehmer
                        },
                        function(data){
                             if (data.indexOf("TRUE") >= 0) {
                                $dialogContent.dialog("close");
                                //calEvent.id = id;
                                //id++;
                                $calendar.weekCalendar("removeUnsavedEvents");
                                $calendar.weekCalendar("updateEvent", calEvent);
                             } else {
                                var jQobj = $(data);
                                jQobj.find('div.errors').addClass('hidden_error');
                                var resultObj = jQobj.filter('#veranstaltung_form').html();
                                $('#validation-errors-wrapper').html(jQobj);
                            }
                        }
                    );

               },
               "löschen" : function() {
                   $.post('/veranstaltung/delete/',
                        {   
                            "uid" : calEvent.id,
                            "ci_csrf_token" : cct
                        },
                        function(data){
                             if (data.indexOf("TRUE") >= 0) {
                                $dialogContent.dialog("close");
                                //calEvent.id = id;
                                //id++;
                                $calendar.weekCalendar("removeUnsavedEvents");
                                $calendar.weekCalendar("updateEvent", calEvent);
                             } else {
                                var jQobj = $(data);
                                jQobj.find('div.errors').addClass('hidden_error');
                                var resultObj = jQobj.filter('#veranstaltung_form').html();
                                $('#validation-errors-wrapper').html(jQobj);
                            }
                        }
                    );
                  $calendar.weekCalendar("removeEvent", calEvent.id);
                  $dialogContent.dialog("close");
               },
               abbrechen : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
         $(window).resize().resize(); //fixes a bug in modal overlay size ??

      },
      eventMouseover : function(calEvent, $event) {
      },
      eventMouseout : function(calEvent, $event) {
      },
      noEvents : function() {

      },
      data : events
   });

   function resetForm($dialogContent) {
      $dialogContent.find("input[type=text]").val("");
      $dialogContent.find("textarea").val("");
      $('#validation-errors-wrapper').html('');
   }

   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

      }
      $endTimeOptions = $endTimeField.find("option");
      $startTimeField.trigger("change");
   }

   var $endTimeField = $("select[name='end']");
   var $endTimeOptions = $endTimeField.find("option");

   //reduces the end time options to be only after the start time options.
   $("select[name='start']").change(function() {
      var startTime = $(this).find(":selected").val();
      var currentEndTime = $endTimeField.find("option:selected").val();
      $endTimeField.html(
            $endTimeOptions.filter(function() {
               return startTime < $(this).val();
            })
            );

      var endTimeSelected = false;
      $endTimeField.find("option").each(function() {
         if ($(this).val() === currentEndTime) {
            $(this).attr("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         //automatically select an end date 2 slots away.
         $endTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });


   var $about = $("#about");

   $("#about_button").click(function() {
      $about.dialog({
         title: "About this calendar demo",
         width: 600,
         close: function() {
            $about.dialog("destroy");
            $about.hide();
         },
         buttons: {
            close : function() {
               $about.dialog("close");
            }
         }
      }).show();
   });


});