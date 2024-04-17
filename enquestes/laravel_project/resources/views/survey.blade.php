<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Generator</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>
@if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

<body>

    <!-- Access processed data in JavaScript -->
    <script>
        var jsonData2 = @json($data);
        var info = @json($info);
        console.log(jsonData2);
        console.log(info);
        // Use jsonData in your JavaScript logic

        // Get the form container
        const formContainer = document.createElement('form');
        formContainer.method = 'POST';
        formContainer.id = 'dynamicForm';
        formContainer.action = "{{ route('enquesta') }}";
        formContainer.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">';


        // Use jsonData in your JavaScript logic
        // Generate the form elements
        //jsonData.preguntes.forEach(pregunta => {
        jsonData2.enquesta.forEach(pregunta => {
            const element = createFormElement(pregunta);
            formContainer.appendChild(element);
        });

        //Pass User info in hidden mode
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = "id_enquesta";
        hiddenInput.value = info.enquesta_id;
        formContainer.appendChild(hiddenInput);
        const hiddenInput2 = document.createElement('input');
        hiddenInput2.type = 'hidden';
        hiddenInput2.name = "id_empresa";
        hiddenInput2.value = info.empresa_id;
        formContainer.appendChild(hiddenInput2);

        const submit = document.createElement('button');
        submit.type =  'submit';
        submit.innerText = "Enviar";
        formContainer.appendChild(submit);

        function createFormElement(pregunta) 
        {
            const element = document.createElement('div');
            var label = "";

            if(pregunta.tipus != 'radio' && pregunta.tipus != 'checkbox')
            {
                label = document.createElement('label');
                label.textContent = pregunta.pregunta;
                label.classList.add("h4");
                label.setAttribute("for", "Enquesta" + pregunta.id);
            }
            else
            {
                label = document.createElement('h4');
                label.textContent = pregunta.pregunta;
                label.classList.add("h4");
            }
            element.appendChild(label);

            // Switch statement to handle different input types
            switch (pregunta.tipus) {
                case 'text':
                case 'date':
                case 'email':
                case 'number':
                    const input = document.createElement('input');
                    input.type = pregunta.tipus;
                    input.id = "Enquesta" + pregunta.id;
                    input.placeholder = pregunta.placeholder;
                    input.name = pregunta.pregunta;
                    element.appendChild(input);
                    break;

                case 'select':
                    const select = document.createElement('select');
                    select.id = pregunta.id;
                    pregunta.opcions.forEach(opcio => {
                        const option = document.createElement('option');
                        option.value = opcio;
                        option.textContent = opcio;
                        select.appendChild(option);
                    });
                    select.name = pregunta.pregunta;
                    element.appendChild(select);
                    break;

                case 'checkbox':
                    pregunta.opcions.forEach(opcio => {
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.id = pregunta.id + "_" + opcio;
                        checkbox.name = pregunta.pregunta + " " + opcio; // Ensure unique names for checkboxes
                        const label = document.createElement('label');
                        label.textContent = opcio;
                        label.setAttribute('for', checkbox.id);
                        element.appendChild(checkbox);
                        element.appendChild(label);
                        element.appendChild(document.createElement('br')); // Add line break for clarity
                    });
                    break;

                case 'radio':
                    pregunta.opcions.forEach(opcio => {
                        const radio = document.createElement('input');
                        radio.type = 'radio';
                        radio.name = pregunta.id + opcio;
                        radio.id = pregunta.pregunta + " " + opcio;
                        const label = document.createElement('label');
                        label.textContent = opcio;
                        label.setAttribute('for', radio.id);
                        element.appendChild(radio);
                        element.appendChild(label);
                        element.appendChild(document.createElement('br')); // Add line break for clarity
                    });
                    break;

                case 'textarea':
                    const textarea = document.createElement('textarea');
                    textarea.id = pregunta.id;
                    textarea.placeholder = pregunta.placeholder;
                    textarea.name = pregunta.placeholder;
                    element.appendChild(textarea);
                    break;
            }

            return element;
        }

        // Append the form to the body
        document.body.appendChild(formContainer);

        </script>
        
        <!-- <form method="POST" id="dynamicForm" action="{{ route('enquesta') }}">
            @csrf
        </form> -->

        <!-- <script src="js/dynamic_survey.js"></script> -->

</body>
</html>
