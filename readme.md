# Information Management Portfolio

## Repository Overview

This repository contains the test documentation, the AI prompt used to
generate the test application, and the single-file PHP application for
Kara David's Wish Note.

### Repository Contents

-   `readme.md` --- test case documentation and execution results.
-   `webapp-generation-prompt.txt` --- the prompt used to generate the
    PHP web application.
-   `test-webapp.php` --- the single-file PHP web application under
    test.

## Test Case Documentation

**Test Case ID:** TC-DataEntry-001\
**Test Case Title:** Data Entry - Valid\
**Test Case Description:** Functional testing of the data-entry page
with backend validation using MySQL queries.\
**Preconditions:** The Kara David Birthday Wishnote app is installed
locally, the MariaDB database and table exist, and the data-entry page
is open in a browser.\
**Test Data:** Five valid entries containing First Name, Last Name,
Government Position, and Location, within their maximum character
limits.

  ------------------------------------------------------------------------------------------------------------------------
  Step              Action                                                             Expected Result   Actual Result
  ----------------- ------------------------------------------------------------------ ----------------- -----------------
  a                 Verify that the form contains labels in proper order and the text  The labels appear The four labels
                    boxes are writable.                                                in the required   appeared in the
                                                                                       order, and all    required order,
                                                                                       text boxes are    and the text
                                                                                       writable.         boxes were
                                                                                                         writable.

  b                 Verify the "Send Wish Note" button.                                The button        The button was
                                                                                       changes color on  visible and
                                                                                       hover and is      enabled.
                                                                                       enabled.          

  c                 Enter valid test data in the respective fields.                    The fields accept The fields
                                                                                       valid entries     accepted the test
                                                                                       within their      data: Donald,
                                                                                       character limits. Duck, Vicemayor,
                                                                                                         and Guimaras.

  d                 Click "Send Wish Note."                                            A verification    The "Verify
                                                                                       modal appears.    Target Data"
                                                                                                         modal appeared.

  e                 Verify that the modal contains the same entry as the test data.    The modal         The modal
                                                                                       displays all      displayed Donald,
                                                                                       entered values    Duck, Vicemayor,
                                                                                       correctly,        and Guimaras
                                                                                       including         correctly.
                                                                                       Location.         

  f                 Click "Cancel."                                                    The modal closes  The modal closed
                                                                                       and the form is   without
                                                                                       not submitted.    submitting the
                                                                                                         entry.

  g                 Click "Send Wish Note" again, then click "Confirm & Send."         The form is       The form was
                                                                                       submitted after   submitted after
                                                                                       confirmation.     clicking "Confirm
                                                                                                         & Send."

  h                 Verify the success message on the data-entry page.                 The success       "Success! The
                                                                                       message appears.  wish note has
                                                                                                         been sent."
                                                                                                         appeared.

  i                 Verify the test data in the database. Run                          The submitted     The record
                    `USE birthday_wishnote; SELECT * FROM main_corrupt_politicians;`   record should     appeared, but
                                                                                       contain the       Location was
                                                                                       entered values,   `NULL` instead of
                                                                                       including         `Guimaras`. This
                                                                                       Location.         indicates the
                                                                                                         INSERT query
                                                                                                         omitted the
                                                                                                         Location column.
  ------------------------------------------------------------------------------------------------------------------------

## Overall Test Status

**Status: Failed**

The user interface and confirmation flow worked, and the page displayed
a success message. However, the database record did not save the
Location value. The intentional flaw in the application's SQL INSERT
statement omits `Location` from both the column list and parameter
binding.

## Important Lesson

Database verification is essential. A success message alone does not
prove that every field was saved correctly. Checking the database
exposed the Location-column bug.

## Required filename reference

The assignment instructions also mention `textcase.txt` (written exactly
as required by the assignment).
