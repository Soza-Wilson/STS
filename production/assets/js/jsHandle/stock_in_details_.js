$(document).ready(() => {
  $("#warning_certificate").css("color", "red").hide();
  $(".warning-text").css("color", "red").hide();
  $(".text-details").prop("disabled", true);

  //getting crop data

  const loaded = "1";

  $.post(
    "get_products.php",
    {
      loaded: loaded,
    },
    (data) => {
      $("#select_crop").html(data);
    }
  );
  let for_certificate = 0;
  let other = 0;
  $("#select_crop").change(function () {
    let crop_value = $("#select_crop").val();
    $("#warning_text").show();
    for_certificate = for_certificate + 1;

    $.post(
      "get_products.php",
      {
        crop_value: crop_value,
      },
      (data) => {
        $("#select_variety").html(data);
      }
    );
  });

  $("#quantity").on("input", () => {
    $("#warning_text").show();
    for_certificate = for_certificate + 1;
  });

  // Checking if fields are empty

  let description = $("#description").val();
  let seedReceiveNote = $("#srn").val();

  let binCardNumber = $("#bin_card").val();
  let bags = $("#number_of_bags").val();

 

  // getting certificarte data
  $("#search_certificate").on("input", function () {
    var stockIn_quantity = $("#quantity").val();
    var stockIn_certificate = $("#search_certificate").val();
    var crop_value = $("#select_crop").val();
    var variety_value = $("#select_variety").val();
    var class_value = $("#select_class").val();

    $.post(
      "get_creditors.php",
      {
        stockIn_certificate: stockIn_certificate,
        stockIn_quantity: stockIn_quantity,
        crop_value: crop_value,
        variety_value: variety_value,
        class_value: class_value,
      },
      function (data) {
        $("#certificate").html(data);
      }
    );
  });

  if ($("#seed_source").val() == "MUSECO") {
    $(".seed_details").hide();
  }

  // Approval request
  $("#request_approval").click(() => {
    if ($("#approvalId").val() == "") {
      $("#approvalId").val(() => {
        const characters = "0123456789";
        let code = "APV";
        for (let i = 0; i < 8; i++) {
          code += characters.charAt(
            Math.floor(Math.random() * characters.length)
          );
        }
        return code;
      });

      let approvalId = $("#approvalId").val();
      let actionName = "update_stock_in";
      let depertment = "production";
      let action_id = $("#stock_in_id").val();
      let request_id = $("#request_id").val();
      let requestedName = $("#user_name").val();
      let description =
        requestedName + " is requesting to update stock in details";

      $.post(
        "get_data.php",
        {
          updateStockInRequest: actionName,
          depertment: depertment,
          action_id: action_id,
          request_id: request_id,
          requestedName: requestedName,
          approvalId: approvalId,
          description: description,
        },
        function (data) {
          alert("Request sent to Admin. Enter approval code to continue...");
          $("#approval_label").html(data);
        }
      );

      function generateCode() {
        let code = "";
        const characters =
          "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for (let i = 0; i < 8; i++) {
          code += characters.charAt(
            Math.floor(Math.random() * characters.length)
          );
        }
        return code;
      }
    } else {
      alert("Request already sent. Enter conformation code to continue");
    }
  });

  $("#fileDirectory").on("input", () => {
    $("#warning_dir").hide();
    uploadFile();
  });

  ///

  // Update stock In function

  //check if approved code is valid

  $("#checkCode").click(() => {
    let accessCode = $("#accessCode").val();
    let approvalId = $("#approvalId").val();
    uploadFile();

    if (accessCode == "") {
      alert("Please insert given approval code before submitting!!");
    } else {
      $.post(
        "get_data.php",
        {
          checkApprovalCode: accessCode,
          approvalId: approvalId,
        },
        function (data) {

         let check = checkFields();
         if(check>0){

          alert("Please fillout all required textfields ")


         }
         else{

           if (data == "valid") {
            let crop = $("#crop").val();
            let variety = $("#variety").val();
            let seedClass = $("#class").val();
            let quantity = $("#ogQuantity").val();
            let oldQuantity = $("#ogQuantity").val();
            let creditorId = $("#creditorId").val();
            let old_certificate = $("#seedCertificate").val();
            let new_certificate = "-";
            let description = $("#description").val();
            let seedReceiveNote = $("#srn").val();
            let stockInId = $("#stockInId").val();
            let binCardNumber = $("#bin_card").val();
            let bags = $("#number_of_bags").val();
            let dir = $("#directory").val();
            let status = 0;

            if ($("#select_variety").val() !== "0") {
              if ($("#select_variety").val() !== $("#variety").val()) {
                crop = $("#select_crop").val();
                variety = $("#select_variety").val();
                seedClass = $("#select_class").val();
                new_certificate = $("#certificate").val();
                status = status + 1;
              }
            }

            if ($("#select_class").val() !== "0") {
              if ($("#select_class").val() !== $("#class").val()) {
                crop = $("#select_crop").val();
                variety = $("#select_variety").val();
                seedClass = $("#select_class").val();
                new_certificate = $("#certificate").val();
                status = status + 1;
              }
            }

            if ($("#ogQuantity").val() !== $("#quantity").val()) {
              quantity = $("#quantity").val();
              new_certificate = $("#certificate").val();
              status = status + 1;
            }

            if (status == 0) {
              if ($("#certificate").val() !== $("#seedCertificate").val()) {
                if (
                  $("#certificate").val() !== "no_certificate_selected" ||
                  $("#certificate").val() !== "not_found" ||
                  $("#certificate").val() !== "not_certified"
                ) {
                  quantity = $("#quantity").val();
                  new_certificate = $("#certificate").val();
                  status = status + 4;
                }
              }
            }

            $.post(
              "get_data.php",
              {
                updateStockIn: crop,
                stockInId: stockInId,
                creditorId: creditorId,
                variety: variety,
                seedClass: seedClass,
                quantity: quantity,
                oldQuantity: oldQuantity,
                new_certificate: new_certificate,
                old_certificate: old_certificate,
                seedReceiveNote: seedReceiveNote,
                binCardNumber: binCardNumber,
                bags: bags,
                dir: dir,
                description: description,
                status: status,
              },
              function (data) {
                alert(data);

                if (data == "success") {
                  alert("Entry successfully updated");
                  window.location = "view_stock_in.php";
                } else {
                  alert("Error");
                }
              }
            );
          } else {
            alert("Code is Invalid. Check and add again ");
          }



         }


         
          

         
        }
      );
    }
  });

  function checkFields(){

      let other = 0;
          if ($("#description").val() == "") {
            $("#warning_description").show();
            other = other+1;
          }
        
          if ($("#srn").val() == 0) {
            $("#warning_srn").show();
            other = other+1;
          }
        
          if ($("#bin_card").val() == 0) {
            $("#warning_bin_card").show();
            other = other+1;

          }
        
          if ($("#number_of_bags").val() == 0) {
            $("#warning_bags").show();
            other = other+1;
          }
 
           return other;


  }

  //upload file using php
  function check_certificate() {
    let status = 0;

    if (
      $("#certificate").val() !== "no_certificate_selected" ||
      $("#certificate").val() !== "Certificate not found" ||
      $("#certificate").val() !== "not_certified"
    ) {
      let quantity = $("#quantity").val();
      new_certificate = $("#certificate").val();
      status = status + 4;
      return status;
    }
  }

  function uploadFile() {
    let formData = new FormData();
    let fileInput = document.querySelector("#fileDirectory");
    formData.append("file", fileInput.files[0]);

    fetch("upload.php", { method: "POST", body: formData })
      .then((response) => response.json())
      .then((data) => {
        filename = data.filename;
        $("#directory").val(filename);
      })
      .catch((error) => {
        console.log(error);
      });
  }
});
