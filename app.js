new Vue({
    el: '#app',
    data: {
      newExpense: {
        description: '',
        amount: 0
      },
      expenses: []
    },
    methods: {
      addExpense() {
        axios.post('api/expenses.php', this.newExpense)
          .then(response => {
            this.expenses.push(response.data);
            this.newExpense = { description: '', amount: 0 };
          })
          .catch(error => {
            console.error(error);
          });
      },
      fetchExpenses() {
        axios.get('api/expenses.php')
          .then(response => {
            this.expenses = response.data;
          })
          .catch(error => {
            console.error(error);
          });
      }
    },
    mounted() {
      this.fetchExpenses();
    }
  });
  