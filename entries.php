<script>
   // The current index being displayed
   var currentIndex = 0;

   /* In this dictionary we list what links we have in the menu */
   /* The utility menus are NOT part of this populating         */
   var links = [
   // Main website interface
       {'name': translate_direct('Home'),
        'url': window.location.protocol + '//' + window.location.hostname + ':80/default2.php',
        'caption': 'By <b>Taiten Peng <i>(@Taitenpeng)</i></b> and <b>J-C Verdié<i>(@jcverdie)</i></b><br><i>Master Linux plumbers</i>',
        'image': '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.2698 4.13816L8.00004 0.868164L0.395752 8.47245L1.45641 9.53311L1.99975 8.98816L2.00004 14.9999H7.25004V9.99989H8.75004V14.9999H14L13.9998 8.98916L14.5437 9.53311L15.6043 8.47245L12.7698 5.63816L12.7699 1.97076H11.2699L11.2698 4.13816ZM3.49975 7.48816L8.00004 2.98989L12.4998 7.48916L12.5 13.4999H10.25V8.49989H5.75004V13.4999H3.50004L3.49975 7.48816Z"/></svg>',
        'logo':'SE', 'recognition':'S', 'snap':'lighttpd'
       },

   // Ogra's demo with camera
       {'name': translate_direct('AI'),
        'url': window.location.protocol + '//' + window.location.hostname + ':6063',
        'caption': 'By <b>Oliver Grawert<i>(@ogra)</i></b><br><i>Master Linux plumber</i>',
        'image': '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 12.4999C7.42246 12.5004 6.85381 12.3577 6.34487 12.0848C5.83593 11.8118 5.40256 11.4169 5.0835 10.9355L5.9165 10.3818C6.14458 10.7256 6.4542 11.0076 6.81773 11.2027C7.18127 11.3978 7.58743 11.4999 8 11.4999C8.41257 11.4999 8.81872 11.3978 9.18226 11.2027C9.54579 11.0076 9.85541 10.7256 10.0835 10.3818L10.9165 10.9355C10.5974 11.4169 10.1641 11.8118 9.65512 12.0848C9.14618 12.3577 8.57753 12.5004 8 12.4999Z"/><path d="M10 7.00005C9.80222 7.00005 9.60888 7.0587 9.44443 7.16858C9.27998 7.27846 9.15181 7.43464 9.07612 7.61736C9.00043 7.80009 8.98063 8.00116 9.01922 8.19514C9.0578 8.38912 9.15304 8.5673 9.29289 8.70715C9.43275 8.84701 9.61093 8.94225 9.80491 8.98083C9.99889 9.01942 10.2 8.99962 10.3827 8.92393C10.5654 8.84824 10.7216 8.72007 10.8315 8.55562C10.9414 8.39117 11 8.19783 11 8.00005C11.0013 7.86837 10.9763 7.73775 10.9265 7.61584C10.8767 7.49393 10.8031 7.38317 10.71 7.29005C10.6169 7.19693 10.5061 7.12332 10.3842 7.07353C10.2623 7.02373 10.1317 6.99875 10 7.00005Z"/><path d="M6 7.00005C5.80222 7.00005 5.60888 7.0587 5.44443 7.16858C5.27998 7.27846 5.15181 7.43464 5.07612 7.61736C5.00043 7.80009 4.98063 8.00116 5.01922 8.19514C5.0578 8.38912 5.15304 8.5673 5.29289 8.70715C5.43275 8.84701 5.61093 8.94225 5.80491 8.98083C5.99889 9.01942 6.19996 8.99962 6.38268 8.92393C6.56541 8.84824 6.72159 8.72007 6.83147 8.55562C6.94135 8.39117 7 8.19783 7 8.00005C7.0013 7.86837 6.97632 7.73775 6.92652 7.61584C6.87672 7.49393 6.80311 7.38317 6.71 7.29005C6.61688 7.19693 6.50612 7.12332 6.38421 7.07353C6.2623 7.02373 6.13168 6.99875 6 7.00005Z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M15 7V8.5H14V10H15V11.5H14V13C13.9994 13.5303 13.7885 14.0386 13.4136 14.4136C13.0386 14.7885 12.5303 14.9994 12 15H4C3.46975 14.9994 2.96139 14.7885 2.58644 14.4136C2.2115 14.0386 2.0006 13.5303 2 13V11.5H1V10H2V8.5H1V7H2V5C2.0006 4.46975 2.2115 3.96139 2.58644 3.58644C2.96139 3.2115 3.46975 3.0006 4 3H5V1H6.5V3H9.5V1H11V3H12C12.5303 3.0006 13.0386 3.2115 13.4136 3.58644C13.7885 3.96139 13.9994 4.46975 14 5V7H15ZM4 4.5C3.72386 4.5 3.5 4.72386 3.5 5V13C3.5 13.2761 3.72386 13.5 4 13.5H12C12.2761 13.5 12.5 13.2761 12.5 13V5C12.5 4.72386 12.2761 4.5 12 4.5H4Z"/></svg>', 
        'logo':'SE', 'recognition':'S', 'snap':'opencv-html-demo'
       },

   // Diego's demo with Sensors
      {'name': translate_direct('Sensors'),
       'url': window.location.protocol + '//' + window.location.hostname + ':7880/ui',
       'caption': 'By <b>Diego Bruno <i>(@dbruno74)</i></b><br><i>Master Linux plumber</i>',
       'image': '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13 6C13 3.23858 10.7614 1 8 1C5.23858 1 3 3.23858 3 6C3 7.63573 3.78547 9.08801 4.99981 10.0002L5 12C5 13.6569 6.34315 15 8 15C9.65685 15 11 13.6569 11 12L11.0012 9.99946C12.215 9.0872 13 7.63528 13 6ZM6.6296 12.6108L9.36995 12.6115C9.13582 13.1353 8.6105 13.5 8 13.5C7.38911 13.5 6.86351 13.1348 6.6296 12.6108ZM8 2.5C6.067 2.5 4.5 4.067 4.5 6C4.5 7.11622 5.02425 8.1425 5.90073 8.80091C6.23595 9.05273 6.44853 9.43167 6.49166 9.84405L6.49981 10.0001L6.5 11.11H9.5L9.5012 9.99857C9.50148 9.52729 9.72324 9.08354 10.1 8.80038C10.976 8.14193 11.5 7.11591 11.5 6C11.5 4.067 9.933 2.5 8 2.5ZM7.999 7.264L6.39127 6.43066L5.70094 7.76237L7.99362 8.95084L10.3033 7.7736L9.62218 6.43718L7.999 7.264Z"/></svg>', 
       'logo':'SE', 'recognition':'S', 'snap':'node-red-demo'
      },

   // Code update demo
      {'name': translate_direct('Update'),
       'url': window.location.protocol + '//' + window.location.hostname + ':4000',
       'caption': 'By <b>Bugra Aydogar <i>(@bugraaydogar)</i></b><br><i>Master Linux plumber</i>',
       'image': '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.74942 9.13447L8.75 1.6084H7.25L7.24942 9.13447L4.1993 6.083L3.31542 6.96689L8 11.6515L12.6846 6.96689L11.8007 6.083L8.74942 9.13447ZM2.5 12V10.9482H1V12C1 13.6568 2.34315 15 4 15H12C13.6569 15 15 13.6568 15 12V10.9482H13.5V12L13.4931 12.1444C13.4204 12.9051 12.7797 13.5 12 13.5H4L3.85554 13.4931C3.09489 13.4204 2.5 12.7797 2.5 12Z"/></svg>', 
       'logo':'SE', 'recognition':'S', 'snap':'device-controller'
      },

  // Matter demo
     {'name': translate_direct('Matter'),
      'url': window.location.protocol + '//' + window.location.hostname + ':5001',
      'caption': 'By <b>Prashant Dhumal <i>(@prashantdhumal)</i></b><br><i>Master Linux plumber</i>',
      'image': '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8.01729 0.261963L7.12491 0.768993V5.37364C6.24543 5.21604 5.44236 4.83336 4.77716 4.28637L3.1438 5.21171C4.39681 6.46405 6.12325 7.2387 8.03202 7.2387C9.92587 7.2387 11.6402 6.47611 12.8908 5.24097L11.2536 4.31348C10.5875 4.85205 9.78603 5.22709 8.90966 5.37883V0.768993L8.01729 0.261963Z"/><path d="M0.0070905 13.9923L0.892373 14.5116L4.88012 12.2093C5.18337 13.0498 5.2535 13.9366 5.11239 14.7862L6.73044 15.738C7.18849 14.0267 6.99613 12.1443 6.04175 10.4912C5.09482 8.85109 3.57723 7.7477 1.88229 7.28227L1.89763 9.16383C2.69711 9.47143 3.42264 9.978 3.99224 10.6611L0 12.966L0.0070905 13.9923Z"/><path d="M16 12.966L15.9929 13.9923L15.1076 14.5116L11.1154 12.2067C10.8086 13.0416 10.7327 13.9232 10.866 14.7693L9.24423 15.7234C8.79984 14.0228 8.9966 12.1569 9.94352 10.5167C10.8979 8.8637 12.432 7.75588 14.1431 7.29691L14.1277 9.17411C13.3214 9.4767 12.5885 9.98084 12.0123 10.6637L16 12.966Z"/></svg>', 
      'logo':'SE', 'recognition':'S', 'snap':'dht11'
     },

  // Core car
     {'name': translate_direct('Core Car'),
      'url': window.location.protocol + '//core-car:5000',
      'caption': 'By <b>Steve Bariault <i>(@skidooman)</i></b><br><i>MacGyvering plumber dispatcher</i>',
      'image': '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M12.5 5.5H11.5C11.4997 5.23487 11.3943 4.98068 11.2068 4.7932C11.0193 4.60572 10.7651 4.50028 10.5 4.5V3.5C11.0303 3.5006 11.5386 3.7115 11.9136 4.08644C12.2885 4.46139 12.4994 4.96975 12.5 5.5Z"/><path d="M14.5 5.5H13.5C13.4991 4.70462 13.1828 3.94208 12.6203 3.37966C12.0579 2.81724 11.2954 2.50089 10.5 2.5V1.5C11.5605 1.50122 12.5772 1.92304 13.3271 2.67292C14.077 3.4228 14.4988 4.43951 14.5 5.5Z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M13.3685 13.5H14.5C14.6326 13.5 14.7598 13.4473 14.8536 13.3536C14.9473 13.2598 15 13.1326 15 13V9.4375C15 9.3345 14.9682 9.23401 14.909 9.14975C14.8497 9.0655 14.7659 9.00161 14.669 8.9668L10.8028 7.57765L9.187 5.54835C9.04646 5.37656 8.86942 5.23822 8.66875 5.14337C8.46808 5.04853 8.24881 4.99955 8.02685 5H4.0288C3.78431 4.9999 3.5435 5.0596 3.32737 5.1739C3.11124 5.28819 2.92635 5.45362 2.7888 5.65575L1.4331 7.64745C1.15061 8.06198 0.999671 8.55207 1 9.0537V13C1 13.1326 1.05268 13.2598 1.14645 13.3536C1.24022 13.4473 1.36739 13.5 1.5 13.5H2.61586C2.91961 14.5384 3.87904 15.2969 5.01563 15.2969C6.15221 15.2969 7.11164 14.5384 7.41539 13.5H8.56899C8.87274 14.5384 9.83217 15.2969 10.9688 15.2969C12.1053 15.2969 13.0648 14.5384 13.3685 13.5ZM9.89463 8.84525L8.02733 6.50001L4.0288 6.5L2.6731 8.49149C2.5605 8.65672 2.49987 8.85276 2.5 9.05271L2.5 12H2.64531C2.978 11.01 3.91353 10.2969 5.01563 10.2969C6.11772 10.2969 7.05325 11.01 7.38594 12H8.59844C8.93113 11.01 9.86666 10.2969 10.9688 10.2969C12.0708 10.2969 13.0064 11.01 13.3391 12H13.5V10.1407L9.89463 8.84525ZM5.01563 13.7969C5.56791 13.7969 6.01563 13.3492 6.01563 12.7969C6.01563 12.2446 5.56791 11.7969 5.01563 11.7969C4.46334 11.7969 4.01563 12.2446 4.01563 12.7969C4.01563 13.3492 4.46334 13.7969 5.01563 13.7969ZM10.9688 13.7969C11.521 13.7969 11.9688 13.3492 11.9688 12.7969C11.9688 12.2446 11.521 11.7969 10.9688 11.7969C10.4165 11.7969 9.96875 12.2446 9.96875 12.7969C9.96875 13.3492 10.4165 13.7969 10.9688 13.7969Z"/></svg>', 
      'logo':'SE', 'recognition':'S', 'snap':'core-car'
     },

  // Automotive video
     {'name': translate_direct('Auto'),
      'url': window.location.protocol + '//' + window.location.hostname + '/auto_video.html',
      'caption': '',
      'image': '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.21967 3.21967C1.36032 3.07902 1.55109 3 1.75 3H11C11.2355 3 11.4572 3.11057 11.599 3.29861L14.849 7.61111C14.947 7.74118 15 7.89963 15 8.0625L15 13C15 13.1326 14.9473 13.2598 14.8536 13.3536C14.7598 13.4473 14.6326 13.5 14.5 13.5H13.3685C13.0648 14.5384 12.1053 15.2969 10.9688 15.2969C9.83217 15.2969 8.87274 14.5384 8.56899 13.5H7.41539C7.11164 14.5384 6.15221 15.2969 5.01562 15.2969C3.87904 15.2969 2.91961 14.5384 2.61586 13.5H1.5C1.36739 13.5 1.24022 13.4473 1.14645 13.3536C1.05268 13.2598 1 13.1326 1 13V3.75001C1 3.55109 1.07902 3.36033 1.21967 3.21967ZM13.5 8.75H8.5V4.5H2.50001L2.5 12H2.64531C2.978 11.01 3.91353 10.2969 5.01562 10.2969C6.11772 10.2969 7.05325 11.01 7.38594 12H8.59844C8.93113 11.01 9.86666 10.2969 10.9688 10.2969C12.0708 10.2969 13.0064 11.01 13.3391 12H13.5L13.5 8.75ZM12.6985 7.25L10.6261 4.5H10V7.25H12.6985ZM6.01562 12.7969C6.01562 13.3492 5.56791 13.7969 5.01562 13.7969C4.46334 13.7969 4.01562 13.3492 4.01562 12.7969C4.01562 12.2446 4.46334 11.7969 5.01562 11.7969C5.56791 11.7969 6.01562 12.2446 6.01562 12.7969ZM11.9688 12.7969C11.9688 13.3492 11.521 13.7969 10.9688 13.7969C10.4165 13.7969 9.96875 13.3492 9.96875 12.7969C9.96875 12.2446 10.4165 11.7969 10.9688 11.7969C11.521 11.7969 11.9688 12.2446 11.9688 12.7969Z"/></svg>', 
      'logo':'SE', 'recognition':'S', 'snap':'auto_video.mp4'
     },

  // Real-time video
     {'name': translate_direct('Real-time'),
      'url': window.location.protocol + '//' + window.location.hostname + '/rt_video.php',
      'caption': '',
      'image': '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.9375 13.5312C10.9751 13.5312 13.4375 11.0688 13.4375 8.03125C13.4375 4.99368 10.9751 2.53125 7.9375 2.53125C4.89993 2.53125 2.4375 4.99368 2.4375 8.03125C2.4375 11.0688 4.89993 13.5312 7.9375 13.5312ZM7.9375 15.0312C11.8035 15.0312 14.9375 11.8972 14.9375 8.03125C14.9375 4.16526 11.8035 1.03125 7.9375 1.03125C4.07151 1.03125 0.9375 4.16526 0.9375 8.03125C0.9375 11.8972 4.07151 15.0312 7.9375 15.0312Z"/><path d="M8.75 3.59375H7.25V8.1875L10.0784 11.0159L11.1391 9.95527L8.75 7.56618V3.59375Z"/></svg>', 
      'logo':'SE', 'recognition':'S', 'snap':'rt_video.mp4'
     }
    ];

// This populates a list of snaps. The txt file was generated after the board was launched based on a REST API call.
var snaps ="<?php if (file_exists('snap_list.txt')) 
    {$json=file_get_contents('snap_list.txt'); 
     $json_data=json_decode($json,true);
     //print_r($json_data);
     foreach($json_data as $key => $value)
     {
        if ($key=='result')
        {
           $stack = array();
           foreach($value as $entry){
              foreach($entry as $entry_key => $entry_value)
              {
                 if (!in_array($entry_value, $stack)){
                    print_r($entry_value . " ");
                    array_push($stack, $entry_value);
                 }
              }
              // print_r($entry_value.' ');
           }
        }
     }
    }?>";

// This detects a list of boards that are available (or not) on the network
var additional_boards=[<?php $connection=@fsockopen('core-car',5000); if(is_resource($connection)) {echo '"core-car",';}?>];

// Also certain items will only show up if the video is in www
var videos = "<?php echo implode(' ', glob('*.mp4'));?>";

// This function is called during the initial populating of the menu
var activeDemos = [];
function getLinkHTMLEntry(index)
{

  // If the file list_snaps.txt has been created, we can verify if the snap is installed. If not, skip
  // Also check if mp4 file exists if this is what is needed in lieu of a snap - or another node on the network
  if(snaps.length != 0 && !snaps.includes(links[index]['snap']) && !videos.includes(links[index]['snap']) && !additional_boards.includes(links[index]['snap'])) {return "";}
  activeDemos.push(index);
  var myString = '<li><a href=\"#\" onclick=\" load_page(\'' + index + '\');\"';
  if(!index) myString+= ' class=\"selected\"';
  myString += '>';
  myString += links[index]['image'] + links[index]['name'] + '</a></li>';
  return myString;
}


function load_page(index) {
     currentIndex = index;
     var url = links[index]['url'];
     var html = '<object type="text/html" data=\"' + url +'\" width="100%" height="100%" ></object>';
     // Relocate the logos and recognition if need be
     repositionLogos(links[index]['logo']);
     updateRecognition(index);
     // If config is open, close it
     closeConfig();
     // If credits is open, close it
     closeCredits();
     document.getElementsByTagName("main")[0].innerHTML=html;
}

function populate_menus() {
    var myString = '';
    activeDemos = [];
    for(var i=0; i < links.length; i++){
        myString+=getLinkHTMLEntry(i);
        myString+="\n";
    }
    return myString;
}

// This causes the page to rotate between different demonstration
var rotationFlag = false; // Flag that tracks if we are rotating or not
function rotateDemos(status, timeToRotation)
{
  // If the demos were rotating, shut it down
  if (rotationFlag || !status){
    rotationFlag = false;
    return;
  }
  rotationFlag = true;
  var currentDemo = 0; // Based on active demos
  setInterval(() => {
    if (!rotationFlag) return;
      // Update the demo being shown
      currentDemo++;
      if (currentDemo >= activeDemos.length) currentDemo = 0;
      load_page(activeDemos[currentDemo]);
  }, timeToRotation);
}


</script>
