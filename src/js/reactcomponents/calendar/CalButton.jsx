export const CalButton = ({date, onClick}) => {
    const [weekday, day, month] = date.split(' ');
        return (
            <button className="border border-white flex flex-col h-[80px] justify-center leading-none text-sm w-[80px] custom-triangle relative" onClick={onClick}>
                <span>{weekday}</span> <span>{day}</span> <span>{month}</span>
            </button>
        )
}
export default CalButton