
function check(msg) {


    if (window.confirm(msg)) { // �m�F�_�C�A���O��\��

        return true; 

    }
    else { // �u�L�����Z���v���̏���

        return false; // ���M�𒆎~

    }

}

function SortSubmit(formid, name, value) {
    var target = document.getElementById(formid);
    // �G�������g���쐬
    var ele = document.createElement('input');
    // �f�[�^��ݒ�
    ele.setAttribute('type', 'hidden');
    ele.setAttribute('name', name);
    ele.setAttribute('value', value);
    // �v�f��ǉ�
    target.appendChild(ele);
    target.submit();
}
