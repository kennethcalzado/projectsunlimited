function createPopup(popupType, title, message, confirmButtonText, cancelButtonText) {
    // Create the main elements for the pop-up
    const popupContainer = $('<div>').addClass('hidden fixed inset-0 z-50 flex items-center justify-center');
    const popupBackground = $('<div>').addClass('bg-black opacity-25 w-full h-full absolute inset-0');
    const popupContent = $('<div>').addClass('bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative');
    const popupIcon = $('<i>').addClass(popupType === 'confirmation' ? 'bi bi-exclamation-circle text-5xl' : (popupType === 'success' ? 'bi bi-check-circle text-5xl' : 'bx bi-exclamation-triangle text-5xl text-red-400'));
    const popupTitle = $('<p>').addClass('font-bold').text(title);
    const popupMessage = $('<p>').addClass('text-sm text-gray-700 mt-1').text(message);
    const buttonContainer = $('<div>').addClass('text-center md:text-right mt-4 md:flex md:justify-end');
    const confirmButton = $('<button>').addClass('block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-yellow-200 text-black rounded-lg font-semibold text-sm md:ml-2 md:order-2 hover:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:border-yellow-500 focus:ring focus:ring-yellow-200 disabled:opacity-25 transition').text(confirmButtonText);
    const cancelButton = $('<button>').addClass('block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4 md:mt-0 md:order-1 hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300 disabled:opacity-25 transition').text(cancelButtonText);

    // Append elements to their respective parent elements
    popupContent.append(
        $('<div>').addClass('md:flex items-center').append(
            $('<div>').addClass('rounded-full flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto').append(popupIcon),
            $('<div>').addClass('mt-4 md:mt-0 md:ml-6 text-center md:text-left').append(popupTitle, popupMessage)
        ),
        buttonContainer.append(confirmButton, cancelButton)
    );
    popupContainer.append(popupBackground, popupContent);

    // Return the generated pop-up
    return popupContainer;
}
